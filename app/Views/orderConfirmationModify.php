<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
    <form action="/ModifyEvent/orderConfirmation" method="post" enctype="multipart/form-data">
        <div class="row">

        <?php
    if (isset($_SESSION["MODIFYEVENTS"]["STEP-1"])) {
?>
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
    <div class="card-body">
        <div class="template-demo">
        <h3 class="card-title text-success">ORDER SUMMARY</h3>
        <p class="card-description">
        Review your order before submission....
        </p>
        </div>
        
        <div class="card-body">
        <blockquote class="blockquote blockquote-primary" style="font-size:0.95rem">
        <table width=100%>
            <tr>
                <td width=50%>
        <table width=100%>
            <tr>
                <td colspan=2>
                    <h4 class="card-title text-info"><strong>Event Details</strong></4>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Event Date & Time: </strong>
                </td>
                <td style="padding-left: 10px">
                    <?=date("F j, Y, g:i a", strtotime($_SESSION["MODIFYEVENTS"]["STEP-1"]["event_datetime"]))?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>No of Guests:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-1"]["no_of_guests"]?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Coat Check?:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-1"]["coat_check"]?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Valid Licensed Bar?:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-1"]["valid_licensed_bar"]?>
                </td>
            </tr>                      
            
            <?php
            if ($_SESSION["MODIFYEVENTS"]["STEP-1"]["valid_licensed_bar"]=="Own Liquor License") {
            ?>
            <tr>
                <td>
                    <strong>Licene file:</strong>
                </td>
                <td style="padding-left: 10px">
                    <a target="_blank" href='<?=$_SESSION["MODIFYEVENTS"]["STEP-1"]["own_license_file"]?>'>Download File</a>
                </td>
            </tr>                      
            <?php
            }
            ?>

            <tr>
                <td>
                    <strong>Coat Check?:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-1"]["coat_check"]?>
                </td>
            </tr>                      
            <tr>
                <td>
                    <strong>No. of Bartenders?:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-1"]["no_of_bartenders"]?>
                </td>
            </tr>                      
            <tr>
                <td>
                    <strong>Need a Hall Rental?:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-1"]["need_a_hall_rental"]?>
                </td>
            </tr>                      
            <tr>
                <td>
                    <strong>Need Security Gaurds?:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-1"]["need_security_gaurds"]?>
                </td>
            </tr>                      
            <tr>
                <td>
                    <strong>How many Security Gaurds?:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-1"]["how_many_security_gaurds"]?>
                </td>
            </tr>
            <?php
                if (isset($_SESSION["MODIFYEVENTS"]["STEP-2"]["label"])) {
            ?>
            <tr>
                <td colspan=2>
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan=2>
                    <h4 class="card-title text-info"><strong>Choose Hall & Menu Option</strong></4>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Your Hall and Location:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-2"]["label"]["selected_venue"]?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Your Event Type:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-2"]["label"]["selected_eventType"]?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Your Selected Menu Option:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-2"]["label"]["selected_menuOption"]?>
                </td>
            </tr>
            <?php
                }
            ?>

            <?php
                if (isset($_SESSION["MODIFYEVENTS"]["STEP-3"]["label"])) {
            ?>
            <tr>
                <td colspan=2>
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan=2>
                    <h4 class="card-title text-info"><strong><?=$_SESSION["MODIFYEVENTS"]["STEP-2"]["label"]["selected_menuOption"]?></strong></4>
                </td>
            </tr>
            <?php
                foreach($_SESSION["MODIFYEVENTS"]["STEP-3"]["label"] as $key => $value) {
                    
            ?>
                    <tr>
                        <td colspan=2 style="vertical-align:top">
                        <table>
                            <tr>
                            <td style="vertical-align:top">
                                <strong><?=$key?>:</strong>
                            </td>
                            <td style="padding-left: 20px">
                            <?php
                                foreach($value as $key1 => $value1) {
                                    if ($key1!="Empty") { 
                            ?>
                                    <table>
                                        <tr>
                                        <td style="vertical-align:top"><?=$key1?>: </td>
                                        <td style="padding-left: 10px"><?=implode(",<br />", $value1)?></td>
                                        </tr>
                                    </table>
                            <?php
                                    } else {
                                        echo implode(",<br />", $value1);
                                    }
                                }
                            ?>
                                </tr>
                            </table>
                        </td>
                    </tr>
            <?php
                }
            ?>
            
            <?php
                }
            ?>
            <?php
                if (isset($_SESSION["MODIFYEVENTS"]["STEP-4"]["label"])) {
            ?>
            <tr>
                <td colspan=2>
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan=2>
                    <h4 class="card-title text-info"><strong>Floor Plan</strong></4>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Floor Plan:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-4"]["label"]?>
                </td>
            </tr>
            <?php
                }
            ?>
            <?php
                if (isset($_SESSION["MODIFYEVENTS"]["STEP-5"]["label"])) {
            ?>
            <tr>
                <td colspan=2>
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan=2>
                    <h4 class="card-title text-info"><strong>Napkin</strong></4>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Napkin:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-5"]["label"]?>
                </td>
            </tr>
            <?php
                }
            ?>
                
            <?php
                if (isset($_SESSION["MODIFYEVENTS"]["STEP-6"]["label"])) {
            ?>
            <tr>
                <td colspan=2>
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan=2>
                    <h4 class="card-title text-info"><strong>Table Cloth Color</strong></4>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Table Cloth:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-6"]["label"]?>
                </td>
            </tr>
            <?php
                }
            ?>
                       
            <?php
                if (isset($_SESSION["MODIFYEVENTS"]["STEP-8"]["label"])) {
            ?>
            <tr>
            <tr>
                <td colspan=2>
                    <h4 class="card-title text-info"><strong>Sound Option</strong></4>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Sound:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?php 
                        if ($_SESSION["MODIFYEVENTS"]["STEP-8"]["sound_select"]==0) {
                            echo "WILL ARRANGE OWN SOUND SYSRTEM";
                        } else {
                            echo $_SESSION["MODIFYEVENTS"]["STEP-8"]["label"];   
                        }
                    ?>
                </td>
            </tr>
            <?php
                }
            ?>
            <?php
                if (isset($_SESSION["MODIFYEVENTS"]["STEP-9"]["label"])) {
            ?>
            <tr>
                <td colspan=2>
                    <h4 class="card-title text-info"><strong>PROFESSIONAL DJ</strong></4>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>DJ Option:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-9"]["label"]?>
                </td>
            </tr>
            <?php
                }
            ?>
            <?php
                if (isset($_SESSION["MODIFYEVENTS"]["STEP-10"]["label"])) {
            ?>
            <tr>
                <td colspan=2>
                    <h4 class="card-title text-info"><strong>STAGE DECORE</strong></4>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Stage Decore Option:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-10"]["label"]?>
                </td>
            </tr>
            <?php
                }
            ?>
            <?php
                if (isset($_SESSION["MODIFYEVENTS"]["STEP-11"]["label"])) {
            ?>
            <tr>
                <td colspan=2>
                    <h4 class="card-title text-info"><strong>LIGHTING SETUP</strong></4>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Lighting Option:</strong>
                </td>
                <td style="padding-left: 10px">
                    <?=$_SESSION["MODIFYEVENTS"]["STEP-11"]["label"]?>
                </td>
            </tr>
            <?php
                }
            ?>

                        <tr>
            <td colspan=2 style="padding-top:20px">
            <button type="submit" class="btn btn-primary mr-2">UPDATE ORDER</button>

            <button type="button" onclick="document.location='/ModifyEvent/modify/<?=$_SESSION["MODIFYEVENTS"]["MODIFY"]?>'" class="btn btn-dark">MODIFY ORDER</button>
            <button type="button" onclick="document.location='/ModifyEvent/reset'" class="btn btn-dark mt-2">RESET SELECTION</button>
            </td>
            </tr>
        
        </table>
            </td>
            <td width=50% style="vertical-align:top">
            
            <table width="100%">
<tr height="30" bgcolor="#E6E6E6" style="text-align:right; font-family: Arial, Helvetica, sans-serif">
  <td width=30%>&nbsp;</td>
  <td width=40% style="border-bottom: 1px solid black">Buffet Price:</td>
  <td width=10% style="border-bottom: 1px solid black">&nbsp;</td>
  <td width=20% style="border-bottom: 1px solid black"><?="$".number_format($buffetPrice, 2, ".", ",")?></td>
</tr>
<tr height="30" bgcolor="#E6E6E6" style="text-align:right; font-family: Arial, Helvetica, sans-serif">
    <td>&nbsp;</td>
  <td style="border-bottom: 1px solid black">Service Charges:</td>
  <td style="border-bottom: 1px solid black">&nbsp;</td>
  <td style="border-bottom: 1px solid black"><?="$".number_format($serviceCharge, 2, ".", ",")?></td>
</tr>
<tr height="30" bgcolor="#E6E6E6" style="text-align:right; font-family: Arial, Helvetica, sans-serif">
<td>&nbsp;</td>
  <td style="border-bottom: 1px solid black"><?=$tax_title?>:</td>
  <td style="border-bottom: 1px solid black">&nbsp;</td>
  <td style="border-bottom: 1px solid black"><?="$".number_format($tax, 2, ".", ",")?></td>
</tr>
<tr height="30" bgcolor="#E6E6E6" style="text-align:right; font-family: Arial, Helvetica, sans-serif">
<td>&nbsp;</td>
  <td style="border-bottom: 1px solid black">Table Cloth:</td>
  <td style="border-bottom: 1px solid black">&nbsp;</td>
  <td style="border-bottom: 1px solid black"><?php if ($tableCloth_price==0) { echo "Included!"; } else { echo "$".number_format($tableCloth_price, 2, ".", ","); } ?></td>
</tr>

<tr height="30" bgcolor="#E6E6E6" style="text-align:right; font-family: Arial, Helvetica, sans-serif">
<td>&nbsp;</td>
<td style="border-bottom: 1px solid black">Napkin:</td>
  <td style="border-bottom: 1px solid black">&nbsp;</td>
  <td style="border-bottom: 1px solid black"><?php if ($napkin_price==0) { echo "Included!"; } else { echo "$".number_format($napkin_price, 2, ".", ","); } ?></td>
</tr>
<?php
    if ($sound_option==1) {
?>
<tr height="30" bgcolor="#E6E6E6" style="text-align:right; font-family: Arial, Helvetica, sans-serif">
<td>&nbsp;</td>
<td style="border-bottom: 1px solid black">Sound:</td>
  <td style="border-bottom: 1px solid black">&nbsp;</td>
  <td style="border-bottom: 1px solid black"><?php if ($sound_price==0) { echo "Included!"; } else { echo "$".number_format($sound_price, 2, ".", ","); } ?></td>
</tr>
<?php
    }
?>
<?php

    foreach($misc_price as $misc_price_key => $misc_price_value) {
?>
<tr height="30" bgcolor="#E6E6E6" style="text-align:right; font-family: Arial, Helvetica, sans-serif">
<td>&nbsp;</td>
<td style="border-bottom: 1px solid black"><?=$misc_price_key?>:</td>
  <td style="border-bottom: 1px solid black">&nbsp;</td>
  <td style="border-bottom: 1px solid black"><?="$".number_format($misc_price_value, 2, ".", ",")?></td>
</tr>
<?php        
    }
?>
<tr height="51" bgcolor="#EAFFEA" style="text-align:right; font-weight:bold; font-family: Arial, Helvetica, sans-serif; color: #000000; border-top: 2px solid black" >
<td>&nbsp;</td>
  <td >Grand Total:</td>
  <td>&nbsp;</td>
  <td bgcolor="#EAFFEA" style="text-align:right; font-family: Arial, Helvetica, sans-serif"><?="$".number_format($total_price, 2, ".", ",")?></td>
</tr>
    </td>
    </table>

            </td>
            </table>
        </blockquote>
    </div>

    </div>
    </div>
</div>
<?php
    }
?>
        </form>
    </div>
</div>
        

