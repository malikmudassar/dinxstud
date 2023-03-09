<?php
// Your CLient ID: 647894656673-opuvei3n79v2pf3vlf65ku67c4tn94tj.apps.googleusercontent.com
// Client Secret: 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
namespace App\Controllers;

use App\Libraries\GroceryCrud;

class ManageReservation extends BaseController
{
    protected $request;

    public function reservation() {
        // error_reporting(E_ALL);
        // ini_set("display_errors", 1);

        if (isset($_SESSION["user_id"])) {


            // $test = new Googlecalendar();
            // //$this->show($test, 1);
            
            echo view('adminHeader');
            if (isset($_SESSION["venues"])) {
                $data['venues'] = $_SESSION["venues"];
            }
            echo view('adminLeftSidebar', $data);
            //$data["temperature"] = $this->getTemperature();
            $data["temperature"] = '';

            $eventsModel = model('App\Models\EventsModel');
            $clientModel = model('App\Models\CompanyClientModel');
            
            $today_events = $eventsModel->where("tblcompany_id", SITE_ID)
                                    ->where("created_at >=", date("Y-m-d")." 00:00:00") 
                                    ->where("created_at <=", date("Y-m-d")." 23:59:59")
                                    ->orderBy("event_datetime", "DESC")
                                    ->get()->getResult();

            $data["todays_total_orders"] = count($today_events);
            
            $data["total_dishes"] = 0;
            $data["total_guests"] = 0;
            foreach ($today_events as $today_event) {
                $data["total_dishes"] += count(explode(",", $today_event->menu_item_selection));
                $data["total_guests"] += $today_event->no_of_guests;
            }

            if (isset($today_events[0])) {
                $first_event_datetime = $today_events[0]->event_datetime;
                $today = date("Y-m-d H:i:s");
                
                $diff = abs(strtotime($first_event_datetime) - strtotime($today));

                $years   = floor($diff / (365*60*60*24)); 
                $months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
                $days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

                $hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 

                $minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 

                $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60)); 

                $str_first_event_in = "Coming Event in: ";
                if ($years>0) {
                    $str_first_event_in .= $years." years, ";
                } 
                if ($months>0) {
                    $str_first_event_in .= $months." months, ";
                } 
                if ($days>0) {
                    $str_first_event_in .= $days." days, ";
                } 
                if ($hours>0) {
                    $str_first_event_in .= $hours." hours, ";
                } 
                if ($minuts>0) {
                    $str_first_event_in .= $minuts." minutes, ";
                } 
                if ($seconds>0) {
                    $str_first_event_in .= $seconds." seconds.";
                } 
                $data["str_first_event_in"] = $str_first_event_in;
            }
            
            $all_events = $eventsModel->where("tblcompany_id", SITE_ID)->orderBy("created_at", "DESC")->get()->getResult();
            
                // echo '<pre>';
                // print_r($all_events);
                // exit;
            //$this->show($all_events, 1);
            $data["total_events"] = count($all_events);

            $data["events_completed"] = 0;
            $data["venues"] = $this->getAllCompanyVenues();
            
            $companyVenueModel = model('App\Models\CompanyVenueModel');
            $menuOptionModel = model('App\Models\MenuOptionModel');
            $companyVenueServiceChargesModel = model('App\Models\CompanyVenueServiceChargesModel');
            $companyVenueTaxes = model('App\Models\CompanyVenueTaxes');
            $companyBuffetPricingModel = model('App\Models\CompanyBuffetPricingModel');
            $companyVenueTableClothModel = model('App\Models\CompanyVenueTableClothModel');
            $companyVenueFlowersModel = model('App\Models\CompanyVenueFlowersModel');
            $companyVenueNapkinsModel = model('App\Models\CompanyVenueNapkinsModel');
            $soundOptionsModel = model('App\Models\SoundOptionsModel');
            $companyMiscPricingModel = model('App\Models\CompanyMiscPricing');

            $miscPricings = $companyMiscPricingModel->where("tblcompany_id", SITE_ID)->get()->getResult();

            $bartender_per_person = 0;
            $security_Guard_per_person = 0;
            $per_person = array();
            $per_hall = array();
            foreach ($miscPricings as $miscPricing) {
                if ($miscPricing->option_key=="Bartender_per_person") {
                    $bartender_per_person = $miscPricing->option_price;
                    $per_person[] = $miscPricing;
                } else if ($miscPricing->option_key=="Security_Guard_per_person") {
                    $security_Guard_per_person = $miscPricing->option_price;
                    $per_person[] = $miscPricing;
                } else {
                    $ex = explode("_", $miscPricing->option_key);
                    if ($ex[count($ex)-2]=="per" && $ex[count($ex)-1]=="person") {
                        $per_person[] = $miscPricing;
                    } else if ($ex[count($ex)-2]=="per" && $ex[count($ex)-1]=="hall") {
                        $per_hall[] = $miscPricing;
                    }
                }
            }
            $priceCount=0;
            foreach($all_events as $event) {
                
                if ($event->status=="completed") {
                    $data["events_completed"]++;
                }
                
                foreach($data["venues"] as $venue) {
                    if ($venue->id==$event->tblcompany_venue_id) {
                        $venues[$venue->name][] = $event->id;
                    }
                }

                $venue_name = $companyVenueModel->where("id", $event->tblcompany_venue_id)->get()->getResult();
                $client_record = $clientModel->where("id", $event->tblcompany_client_id)->get()->getResult();

                $client_name = "";
                $avator="";
                foreach ($client_record as $client_rec) {
                    $client_name = $client_rec->first_name." ".$client_rec->last_name;

                    if ($client_rec->gender=="male") {
                        $avator = "https://chandani.dinxstudio.com/assets/images/male.png";
                    } else {
                        $avator = "https://chandani.dinxstudio.com/assets/images/female.png";
                    }
                }
                
                $data["new_clients"][$client_name] = array(
                    "name" => $client_name,
                    "avator" => $avator,
                    "venue" => $venue_name[0]->name,
                    "no_of_guests" => $event->no_of_guests, 
                    "event_datetime" =>  date("F j, Y, g:i a", strtotime($event->event_datetime))
                );
                                        
                $pricing = $companyBuffetPricingModel->where("tblcompany_venue_id", $event->tblcompany_venue_id)
                                                    ->where("tblcompany_menuOption_id", $event->tblcompany_menuOption_id)
                                                    ->get()->getResult();
                
                $serviceCharges = $companyVenueServiceChargesModel->where("tblcompany_venue_id", $event->tblcompany_venue_id)->get()->getResult();
                $companyVenueTax = $companyVenueTaxes->where("tblcompany_venue_id", $event->tblcompany_venue_id)->get()->getResult();
                $tableCloth = $companyVenueTableClothModel->where("tblcompany_venue_id", $event->tblcompany_venue_id)
                                                            ->where("id", $event->tableCloth_id)        
                                                            ->get()
                                                            ->getResult();
                
                if(empty($tableCloth)){
                    $tableCloth=0;
                }
                
                $flowers = $companyVenueFlowersModel->where("tblcompany_venue_id", $event->tblcompany_venue_id)
                                                            ->where("id", $event->flower_id)        
                                                            ->get()
                                                            ->getResult();
                                                            
                $flowers=0;                                            
                $napkin = $companyVenueNapkinsModel->where("tblcompany_venue_id", $event->tblcompany_venue_id)
                                                            ->where("id", $event->napkin_id)        
                                                            ->get()
                                                            ->getResult();
                                                            
                if(empty($napkin)){
                    $napkin=0;
                }                                            
                $sound_option = 0;
                $soundOption = array();
                if ($event->sound_option_id!=0) {
                    $soundOption = $soundOptionsModel->where("tblcompany_id", SITE_ID)->where("id", $event->sound_option_id)->get()->getResult();
                    $sound_option = 1;
                }
                
                if($event->need_a_hall_rental !='' && $event->need_a_hall_rental=='Yes'){
                    $hallRental ='Yes';
                }else{
                    $hallRental ='No';
                }
                
                
                $price = 0;
                $sound_price = 0;
                if (date("w", strtotime($event->event_datetime))==0) {
                    if($hallRental=='Yes'){
                     $price = $pricing[0]->Sunday;
                    }else{
                      $price = 0;    
                    }
                    $buffetPrice = $price;
                    $price += (($serviceCharges[0]->Sunday*$price)/100);
                    $serviceCharge = (($serviceCharges[0]->Sunday*$price)/100);
                    $price += (($companyVenueTax[0]->Sunday*$price)/100);
                    $tax = (($companyVenueTax[0]->Sunday*$price)/100);
                    if($tableCloth!=0){
                    $price += (($tableCloth[0]->Sunday*$price)/100);
                    $tableCloth_price = (($tableCloth[0]->Sunday*$price)/100);
                    }else{
                        $tableCloth_price = 0;
                    }
                    //$price += (($flowers[0]->Tuesday*$price)/100);
                    //$flowers_price = (($flowers[0]->Tuesday*$price)/100);
                    $flowers_price = 0;
                    if($napkin!=0){
                    $price += (($napkin[0]->Sunday*$price)/100);
                    $napkin_price = (($napkin[0]->Sunday*$price)/100);
                    }else{
                        $napkin_price = 0;
                    }

                    if ($sound_option) {
                        $price += (($soundOption[0]->Sunday*$price)/100);
                        $sound_price = (($soundOption[0]->Sunday*$price)/100);
                    }
                } else if (date("w", strtotime($event->event_datetime))==1) {
                    
                    if($hallRental=='Yes'){
                     $price = $pricing[0]->Monday;
                    }else{
                      $price = 0;    
                    }
                    $buffetPrice = $price;
                    $price += (($serviceCharges[0]->Monday*$price)/100);
                    $serviceCharge = (($serviceCharges[0]->Monday*$price)/100);
                    $price += (($companyVenueTax[0]->Monday*$price)/100);
                    $tax = (($companyVenueTax[0]->Monday*$price)/100);
                    
                    if($tableCloth!=0){
                    $price += (($tableCloth[0]->Monday*$price)/100);
                    $tableCloth_price = (($tableCloth[0]->Monday*$price)/100);
                    }else{
                        $tableCloth_price = 0;
                    }
                    
                    //$price += (($flowers[0]->Tuesday*$price)/100);
                    //$flowers_price = (($flowers[0]->Tuesday*$price)/100);
                    $flowers_price = 0;
                    if($napkin!=0){
                    $price += (($napkin[0]->Monday*$price)/100);
                    $napkin_price = (($napkin[0]->Monday*$price)/100);
                    }else{
                        $napkin_price = 0;
                    }

                    if ($sound_option) {
                        $price += (($soundOption[0]->Monday*$price)/100);
                        $sound_price = (($soundOption[0]->Monday*$price)/100);
                    }
                } else if (date("w", strtotime($event->event_datetime))==2) {
                    if($hallRental=='Yes'){
                     $price = $pricing[0]->Tuesday;
                    }else{
                      $price = 0;    
                    }
                    $buffetPrice = $price;
                    $price += (($serviceCharges[0]->Tuesday*$price)/100);
                    $serviceCharge = (($serviceCharges[0]->Tuesday*$price)/100);
                    $price += (($companyVenueTax[0]->Tuesday*$price)/100);
                    $tax = (($companyVenueTax[0]->Tuesday*$price)/100);
                    
                    if($tableCloth!=0){
                    $price += (($tableCloth[0]->Tuesday*$price)/100);
                    $tableCloth_price = (($tableCloth[0]->Tuesday*$price)/100);
                    }else{
                        $tableCloth_price = 0;
                    }
                    //$price += (($flowers[0]->Tuesday*$price)/100);
                    //$flowers_price = (($flowers[0]->Tuesday*$price)/100);
                    $flowers_price = 0;
                    if($napkin!=0){
                    $price += (($napkin[0]->Tuesday*$price)/100);
                    $napkin_price = (($napkin[0]->Tuesday*$price)/100);
                    }else{
                        $napkin_price = 0;
                    }

                    if ($sound_option) {
                        $price += (($soundOption[0]->Tuesday*$price)/100);
                        $sound_price = (($soundOption[0]->Tuesday*$price)/100);
                    }
                } else if (date("w", strtotime($event->event_datetime))==3) {
                    if($hallRental=='Yes'){
                     $price = $pricing[0]->Wednesday;
                    }else{
                      $price = 0;    
                    }
                    $buffetPrice = $price;
                    $price += (($serviceCharges[0]->Wednesday*$price)/100);
                    $serviceCharge = (($serviceCharges[0]->Wednesday*$price)/100);
                    $price += (($companyVenueTax[0]->Wednesday*$price)/100);
                    $tax = (($companyVenueTax[0]->Wednesday*$price)/100);
                    
                    if($tableCloth!=0){
                    $price += (($tableCloth[0]->Wednesday*$price)/100);
                    $tableCloth_price = (($tableCloth[0]->Wednesday*$price)/100);
                    }else{
                        $tableCloth_price = 0;
                    }
                    //$price += (($flowers[0]->Tuesday*$price)/100);
                    //$flowers_price = (($flowers[0]->Tuesday*$price)/100);
                    $flowers_price = 0;
                    if($napkin!=0){
                    $price += (($napkin[0]->Wednesday*$price)/100);
                    $napkin_price = (($napkin[0]->Wednesday*$price)/100);
                    }else{
                        $napkin_price = 0;
                    }

                    if ($sound_option) {
                        $price += (($soundOption[0]->Wednesday*$price)/100);
                        $sound_price = (($soundOption[0]->Wednesday*$price)/100);
                    }
                } else if (date("w", strtotime($event->event_datetime))==4) {
                    if($hallRental=='Yes'){
                     $price = $pricing[0]->Thursday;
                    }else{
                      $price = 0;    
                    }
                    $buffetPrice = $price;
                    $price += (($serviceCharges[0]->Thursday*$price)/100);
                    $serviceCharge = (($serviceCharges[0]->Thursday*$price)/100);
                    $price += (($companyVenueTax[0]->Thursday*$price)/100);
                    $tax = (($companyVenueTax[0]->Thursday*$price)/100);
                    
                    if($tableCloth!=0){
                    $price += (($tableCloth[0]->Thursday*$price)/100);
                    
                    $tableCloth_price = (($tableCloth[0]->Thursday*$price)/100);
                    }else{
                        $tableCloth_price = 0;
                    }
                    //$price += (($flowers[0]->Tuesday*$price)/100);
                    //$flowers_price = (($flowers[0]->Tuesday*$price)/100);
                    $flowers_price = 0;
                    if($napkin!=0){
                    $price += (($napkin[0]->Thursday*$price)/100);
                    $napkin_price = (($napkin[0]->Thursday*$price)/100);
                    }else{
                        $napkin_price = 0;
                    }

                    if ($sound_option) {
                        $price += (($soundOption[0]->Thursday*$price)/100);
                        $sound_price = (($soundOption[0]->Thursday*$price)/100);
                    }
                } else if (date("w", strtotime($event->event_datetime))==5) {
                    if($hallRental=='Yes'){
                     $price = $pricing[0]->Friday;
                    }else{
                      $price = 0;    
                    }
                    $buffetPrice = $price;
                    $price += (($serviceCharges[0]->Friday*$price)/100);
                    $serviceCharge = (($serviceCharges[0]->Friday*$price)/100);
                    $price += (($companyVenueTax[0]->Friday*$price)/100);
                    $tax = (($companyVenueTax[0]->Friday*$price)/100);
                    
                    if($tableCloth!=0){
                    $tableCloth_price = (($tableCloth[0]->Friday*$price)/100);
                    $price += (($tableCloth[0]->Friday*$price)/100);
                    }else{
                        $tableCloth_price = 0;
                    }
                    
                    //$price += (($flowers[0]->Tuesday*$price)/100);
                    //$flowers_price = (($flowers[0]->Tuesday*$price)/100);
                    $flowers_price = 0;
                    if($napkin!=0){
                    $napkin_price = (($napkin[0]->Friday*$price)/100);
                    $price += (($napkin[0]->Friday*$price)/100);
                    }else{
                        $napkin_price = 0;
                    }

                    if ($sound_option) {
                        $price += (($soundOption[0]->Friday*$price)/100);
                        $sound_price = (($soundOption[0]->Friday*$price)/100);
                    }
                } else if (date("w", strtotime($event->event_datetime))==6) {
                    if($hallRental=='Yes'){
                     $price = $pricing[0]->Saturday;
                    }else{
                      $price = 0;    
                    }
                    $buffetPrice = $price;
                    $price += (($serviceCharges[0]->Saturday*$price)/100);
                    $serviceCharge = (($serviceCharges[0]->Saturday*$price)/100);
                    $price += (($companyVenueTax[0]->Saturday*$price)/100);
                    $tax = (($companyVenueTax[0]->Saturday*$price)/100);
                    
                    if($tableCloth!=0){
                    $price += (($tableCloth[0]->Saturday*$price)/100);
                    $tableCloth_price = (($tableCloth[0]->Saturday*$price)/100);
                    }else{
                        $tableCloth_price = 0;
                    }
                    //$price += (($flowers[0]->Tuesday*$price)/100);
                    //$flowers_price = (($flowers[0]->Tuesday*$price)/100);
                    $flowers_price = 0;
                    
                    if($napkin!=0){
                    $price += (($napkin[0]->Saturday*$price)/100);
                    $napkin_price = (($napkin[0]->Saturday*$price)/100);
                    }else{
                        $napkin_price = 0;
                    }

                    if ($sound_option) {
                        $price += (($soundOption[0]->Saturday*$price)/100);
                        $sound_price = (($soundOption[0]->Saturday*$price)/100);
                    }
                }

                $price *= $event->no_of_guests;

                $data["buffetPrice"] = $buffetPrice*$event->no_of_guests;
                $data["serviceCharge"] = $serviceCharge*$event->no_of_guests;
                $data["tax_title"] = $companyVenueTax[0]->name;
                $data["tax"] = $tax*$event->no_of_guests;
                $data["tableCloth_price"] = $tableCloth_price*$event->no_of_guests;
                $data["flowers_price"] = $flowers_price*$event->no_of_guests;
                $data["napkin_price"] = $napkin_price*$event->no_of_guests;
                $data["sound_option"] = $sound_option;
                $data["sound_price"] = $sound_price;

                $total_person = 0;
                $data["total_price"] = 0;
                $misc_price = array();
                
                if (count($per_person)>0) {
                    foreach($per_person as $option) {
                        eval("\$total_person = \$event->$option->event_table_field_name;"); 
                        $price += $total_person*$option->option_price;
                        $misc_price[$option->title] = $total_person*$option->option_price;
                        $data["total_price"] += $misc_price[$option->title];
                    }
                }

                $isOptionSelected = 0;
                if (count($per_hall)>0) {
                    foreach($per_hall as $option) {
                        eval("\$isOptionSelected = \$event->$option->event_table_field_name;"); 
                        if ($isOptionSelected==1) {
                            $price += $option->option_price;
                            $misc_price[$option->title] = $option->option_price;
                            $data["total_price"] += $misc_price[$option->title];
                        }
                    }
                }

                $data["misc_price"] = $misc_price;
                $data["total_price"] += floatval($data["buffetPrice"]) + floatval($data["serviceCharge"]) + floatval($data["tax"]) + 
                                        floatval($data["tableCloth_price"]) + floatval($data["flowers_price"]) + floatval($data["napkin_price"]) + $data["sound_price"];
                                        
                if($hallRental=='Yes'){
                 $data["all_events"][] = array(
                    "id" => $event->id,
                    "client_name" => $client_name,
                    "venue" => $venue_name[0]->name,
                    "menu" => $menuOptionModel->where("id", $event->tblcompany_menuOption_id)->get()->getResult()[0]->name,
                    "no_of_guests" => $event->no_of_guests, 
                    "Payment" => "$".number_format($data["total_price"], 2, ".", ","),
                    "event_datetime" =>  date("F j, Y, g:i a", strtotime($event->event_datetime)),
                    "status" => $event->status
                 );
                }else{
                   $data["all_events"][] = array(
                    "id" => $event->id,
                    "client_name" => $client_name,
                    "venue" => $venue_name[0]->name,
                    "menu" => 'No menu',
                    "no_of_guests" => $event->no_of_guests, 
                    "Payment" => "$".number_format($data["total_price"], 2, ".", ","),
                    "event_datetime" =>  date("F j, Y, g:i a", strtotime($event->event_datetime)),
                    "status" => $event->status
                 ); 
                }
            }
            $data["all_venues"] = $venues;
            echo view('adminReservation', $data);
            echo view('adminFooter');
        } else {
            return redirect()->to(site_url().'Administration');
        }
    }
    
    public function delete() {
        $_SESSION["EVENTS"] = array();
        $event_id = $this->request->uri->getSegments()[2];
        
        $this->db= \Config\Database::connect();
        $builder = $this->db->table('tblcompany_events');
        $event=$builder->delete(["id"=>$event_id]);

        return redirect()->to(site_url().'ManageReservation/reservation');
    }
}
