          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card position-relative">
                <div class="card-body">
                  
                <div style='height:20px;'></div>  
                <div style="padding: 10px">
                <?php
                  if (isset($add_button_link)) {
                ?>
                <button onclick="document.location='<?=$add_button_link?>'" type="button" class="btn btn-primary mr-2"><?=$add_button_name?></button>
                <br />
                <br />
                <?php
                  }
                ?>
                <?php echo $output; ?>
                </div>
                <?php /* foreach($js_files as $file): ?>
                    <script src="<?php echo $file; ?>"></script>
                <?php endforeach;*/ ?>
                

                </div>
              </div>
            </div>
          </div>
        </div>