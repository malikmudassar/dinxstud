	<!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">


            <div class="col-md-12 grid-margin">
              <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">PROFESSIONAL DJ</h4>
                  <p class="card-description">
                  Need a professional DJ?
                  </p>
                  <form action="/AdminEvents/dj" method="post" enctype="multipart/form-data">
                  <div class="form-row">
                    <div class="form-holder" style="padding-left:10px">
                      <input style="vertical-align:top; margin-top:5px" name="dj_select" id="dj_select_0" type="radio" <?php if (isset($dj_select)) {if ($dj_select==0) echo "checked";} else {echo "checked";} ?> value="0" />                        
                      <label for="dj_select_0">  NEED A DJ</label>
                      <br />
                      <input style="vertical-align:top; margin-top:5px" name="dj_select" id="dj_select_1" type="radio" <?php if (isset($dj_select) && $dj_select==1) echo "checked"; ?> value="1" />                        
                      <label for="dj_select_1">   WILL BRING OWN DJ </label>
                    </div>
                    
                    <small>Patch-in Fee - Please make a note that your DJ will have to pay a hook-up fee to use or bring in any outside equipment.</small>
                  </div>
                    
                    <br />
                    
                    <input type="button" class="btn btn-light" onclick="document.location='/AdminEvents/sound'" value="Previous" />
                  <button type="submit" class="btn btn-primary mr-2">NEXT</button>
                  </form>
                </div>
              </div>
            </div>

            <?= $this->include("summary"); ?>                  

              </div>

              
            </div>
          </div>
        
        </div>
        

