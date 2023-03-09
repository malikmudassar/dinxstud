<!-- partial -->
      <title>Chandni Halls Online Booking System</title>
      
      <div class="main-panel">
        <div class="content-wrapper">
        
          <div class="row">
          
            <div class="col-md-9 grid-margin stretch-card">
              <div class="card">
                
                <div class="card">
                <div class="card-body">
                  <p class="card-title">Register Admin</p>
                  <?php if(isset($validation)):?>
					<div class="form-row">
						<div class="alert alert-danger"><?= $validation->listErrors() ?></div>
					</div>
				  <?php endif;?>
                  <div class="row">
                    <div class="col-12">
                        <form action="/ManageClient/saveadmin" method="post">

							<div class="form-row" style="margin-bottom: 2%;">
								<div class="form-holder" style="width: 45%; padding-right: 2%;">
									<input type="text" name="first_name" placeholder="First Name" class="form-control">
								</div>
								<div class="form-holder" style="width: 45%;">
									<input type="text" name="last_name"placeholder="Last Name" class="form-control">
								</div>
							</div>
                            
							<div class="form-row" style="margin-bottom: 2%;">
								<div class="form-holder" style="width: 45%; padding-right: 2%;">
									<input type="text" name="email" placeholder="Your Email" class="form-control">
								</div>
								<div class="form-holder" style="width: 45%;">
									<input type="text" name="phone" placeholder="Phone Number" class="form-control">
								</div>
							</div>
							<div class="form-row" style="margin-bottom: 2%;">
								<div class="form-holder" style="width: 45%; padding-right: 2%;">
									<input type="text" name="age" placeholder="Enter Age" class="form-control">
								</div>
								<div class="form-holder" style="width: 45%;">
									<input type="password" name="password" placeholder="Enter new password" class="form-control">
								</div>
							</div>
							<div>
								<label>
									<input type="hidden" name="terms" value="1"> 
							</div>
								<br />
							<div class="form-row">
								<div class="form-holder">
									<input type="submit" value="Register" class="form-control submit-button-chandni">
								</div>
								
							</div>
							</form>
                    </div>
                  </div>
                </div>
                  
                  
                  <!--
                  <canvas id="order-chart"></canvas>
                  -->
                  
                  
                  <?php /*?>
                   <p class="card-title">EVENTS - CALENDAR VIEW</p>
                   
                  <iframe src="https://calendar.google.com/calendar/embed?height=700&wkst=1&bgcolor=%23ffffff&ctz=America%2FToronto&src=ZW4uY2FuYWRpYW4jaG9saWRheUBncm91cC52LmNhbGVuZGFyLmdvb2dsZS5jb20&color=%230B8043" style="border-width:0" width="100%" height="700" frameborder="0" scrolling="no"></iframe>
                   
                   <!--
                  <div><img src="https://chandani.dinxstudio.com/assets/images/calendar.jpg" width="100%" height="auto"/></div>
                  -->
                  <?php */?>
                  
                </div>
                
              </div>
            </div>
          </div>
        </div>
        

