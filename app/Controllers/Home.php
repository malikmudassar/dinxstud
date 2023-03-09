<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index() {
        // echo 'in controller function';exit;
        helper(['form']);
        helper('html');
        $logged_in = false;
        $test='777';
        $data["isNewRegistered"] = "";
        
        if (isset($this->request->uri->getSegments()[2])) {
            $data["isNewRegistered"] = $this->request->uri->getSegments()[2];
        }

        $companyModel = model('App\Models\CompanyModel');

        $company = $companyModel->find(SITE_ID);

        $data['company_name'] = $company["name"];
        $data['logo'] = $company["logo"];        

        if (!(isset($_SESSION["client_id"]))) {
    
            if ($this->request->getMethod() == "post") {
                $post = $this->request->getRawInput(); 
                $rules = [
                    'email' => 'required',
                    'password'  => ['rules'  => 'required','errors' => [
                        'required' => 'Enter a valid password',
                        ],
                        
                         
                    ]
                ];
                $session = session();
                if($this->validate($rules)){
                $cUserModel = model('App\Models\CompanyClientModel');
    
                $email = $this->request->getVar('email');
                $password = $this->request->getVar('password');
                
                $data = $cUserModel->where('email', $email)->first();

                // redundent 
                $data['company_name'] = $company["name"];
                $data['logo'] = $company["logo"];        
            
                if(isset($data['password'])) {
                    $pass = $data['password'];
                    $authenticatePassword = md5($password, $pass);

                    if($authenticatePassword){
                        $ses_data = [
                            'client_id' => $data['id'],
                            'name' => $data['first_name']." ".$data['last_name'],
                            'email' => $data['email'],
                            "logo" => $company["logo"],
                            "avatar" => ($data["avatar"]!="")?$data["avatar"]:"https://chandani.dinxstudio.com/assets/images/User-Administrator-Blue-icon.png",
                            'isLoggedIn' => TRUE
                        ];

                        $session->set($ses_data); 
                         
                        $logged_in = true;
                        return redirect()->to(site_url().'home');
                        
                    } else {
                        $data['validation'] = 'Password is incorrect.';
                    }
                } else {
                    $data['validation'] = 'Email does not exist.';
                }
                }else{
                     $data['validation']='';
                     $data['validationError'] = $this->validator;
                     return view('home', $data);
                }
            }
            return view('home', $data);    
        } else {
            $logged_in = true;
        }
        
        if ($logged_in==true) {
            //echo $test;
            //exit;
            //$data["temperature"] = $this->getTemperature();
            $data["temperature"] = '';

            $eventsModel = model('App\Models\EventsModel');
            $data["my_events"] = $eventsModel
                                        ->select('tblcompany_events.*, '.
                                                 'tblcompany_venues.name AS Venue_Name, '.
                                                 'tblcompany_event_types.event_type AS event_type, '.
                                                 'tblcompany_event_types.description AS event_type_description, '.
                                        'tblcompany_menuOptions.name AS menuOption_name')
                                        ->where("tblcompany_events.tblcompany_id`", SITE_ID)
                                        ->where("tblcompany_client_id", $_SESSION['client_id'])
                                        ->join('tblcompany_venues', 'tblcompany_venues.id = tblcompany_events.tblcompany_venue_id')
                                        ->join('tblcompany_event_types', 'tblcompany_events.tblcompany_event_type_id = tblcompany_event_types.id')
                                        ->join('tblcompany_menuOptions', 'tblcompany_menuOptions.id = tblcompany_events.tblcompany_menuOption_id')->orderBy("created_at", "DESC")
                                        ->get()->getResult();
            $data["my_events_2"] = $eventsModel
                                        ->select('tblcompany_events.*, '.
                                                 'tblcompany_venues.name AS Venue_Name, '.
                                                 'tblcompany_event_types.event_type AS event_type, '.
                                                 'tblcompany_event_types.description AS event_type_description, ')
                                        ->where("tblcompany_events.tblcompany_id`", SITE_ID)
                                        ->where("tblcompany_client_id", $_SESSION['client_id']) 
                                        ->where("tblcompany_menuOption_id",0)
                                        ->join('tblcompany_venues', 'tblcompany_venues.id = tblcompany_events.tblcompany_venue_id')
                                        ->join('tblcompany_event_types', 'tblcompany_events.tblcompany_event_type_id = tblcompany_event_types.id')->orderBy("created_at", "DESC")
                                        ->get()->getResult();                        
            
            $menuModel = model('App\Models\MenuModel');
            $data_menu = array();
            foreach ($data["my_events"] as $my_event) {
                $menu_items = explode(",", $my_event->menu_item_selection);
                $menu_item_name = array();
                if(!empty($menu_items)){
                foreach ($menu_items as $menu_item) {
                    if(!empty($menu_item)){
                    $menu_item_name[] = $menuModel->where("id", $menu_item)->get()->getResult()[0]->item_name;
                    }
                }
                } 
                $data_menu[] = array(
                                    'menu_item_selection' => $my_event->menu_item_selection,
                                    'menu_item_name' => implode(', ', $menu_item_name));
            }

            // $this->show($data_menu, 1);
            // $this->show($data["my_events"], 1);
            // echo 'starting to load views';exit;
            $data["menu_item_name"] = $data_menu;
              echo view('clientHeader');
              echo view('clientLeftSidebar', $data);
              echo view('clientDashboard', $data);
              echo view('clientFooter');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(site_url().'home');
    }
}
