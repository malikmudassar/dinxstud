


      <!-- partial -->
      <title><?=$company_name?> Online Booking System</title>
      
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card tale-bg">
                <div class="card-people mt-auto">

                  <div class="card">
                <div class="card-body">
                  <p class="card-title">MY EVENT(s) DETAILS</p>
                  <div class="row">
                   <div class="col-md-12 grid-margin stretch-card">
                      <div class="table-responsive">
                        <table width="100%" class="display expandable-table">
                          <thead>
                            <tr>
                              <th width="18%">Hall / Venue</th>
                              <th width="15%">Event Type and Date</th>
                              <th width="25%">Dishes in Today's Menu</th>
                              <th width="15%">Menu Name</th>
                              <th width="14%">No. of Expected Guests</th>
                              <th width="13%">Action</th>
                              
                            </tr>
                        <?php
                        //   echo '<pre>';
                        //   print_r($my_events_2);
                        //   exit;
                          if (count($my_events)>0) {
                            foreach ($my_events as $my_event) {
                        ?>
                            
                        <tr>
                          <td class="font-weight-bold"><?=$my_event->Venue_Name?></td>
                          <td class="font-weight-bold"><?=$my_event->event_type?></td>
                          <td class="font-weight-bold">
                          <?php
                            foreach ($menu_item_name as $menu_item) {
                              if ($my_event->menu_item_selection==$menu_item["menu_item_selection"]) {
                                echo $menu_item["menu_item_name"];
                                break;
                              }
                            }
                          ?>
                          </td>
                          <td><?=$my_event->menuOption_name?></td>
                          <td><?=$my_event->no_of_guests?></td>                
                          <td>
                              <a href='/events/delete/<?=$my_event->id?>' class="btn btn-light" onclick="return confirm('Are you sure you want to delete this event?');"> DELETE</a>
                              <input type="button" class="btn btn-light" onclick="document.location='/ModifyEvent/modify/<?=$my_event->id?>'" value="MODIFY" />
                              <input type="button" class="btn btn-light" onclick="document.location='/ModifyEvent/viewSummary/<?=$my_event->id?>'" value="ORDER SUMMARY" />
                          </td>                
                        </tr>
                        <?php
                            }
                            
                          } 
                        ?>
                        
                        <?php
                        
                          if (count($my_events_2)>0) {
                            foreach ($my_events_2 as $my_event) {
                        ?>
                        <tr>
                          <td class="font-weight-bold"><?=$my_event->Venue_Name?></td>
                          <td class="font-weight-bold"><?=$my_event->event_type?></td>
                          <td class="font-weight-bold">
                          No menu item selected
                          </td>
                          <td>No menu selected</td>
                          <td><?=$my_event->no_of_guests?></td>                
                          <td>
                              <a href='/events/delete/<?=$my_event->id?>' class="btn btn-light" onclick="return confirm('Are you sure you want to delete this event?');"> DELETE</a>
                              <input type="button" class="btn btn-light" onclick="document.location='/ModifyEvent/modify/<?=$my_event->id?>'" value="MODIFY" />
                              <input type="button" class="btn btn-light" onclick="document.location='/ModifyEvent/viewSummary/<?=$my_event->id?>'" value="ORDER SUMMARY" />
                          </td>                
                        </tr>
                        <?php
                            }
                            
                          } 
                          if(count($my_events_2)==0 && count($my_events)==0) {
                            ?>
                            <tr>
                              <td colspan=6>No Orders to Display!</td>
                              
                            </tr>
                            <?php
                          }
                        ?>
                         
                          </thead>
                      </table>
                      </div>
                    </div>
                  </div>
              </div>
      </div>
     </div>
     </div>
    </div>
    </div>
    </div>
