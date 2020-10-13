<!-- Donate Form Modal -->
<div class="modal fade" id="DonateModal" tabindex="-1" role="dialog" data-backdrop="static">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<div class="row">
                    <div class="col-md-6 col-sm-6 donate-amount-option">
                        <h4>Choose an amount</h4>
                        <ul class="predefined-amount">
                            <li><label><input type="radio" name="donation-amount">$10</label></li>
                            <li><label><input type="radio" name="donation-amount">$20</label></li>
                            <li><label><input type="radio" name="donation-amount">$30</label></li>
                            <li><label><input type="radio" name="donation-amount">$50</label></li>
                            <li><label><input type="radio" name="donation-amount">$100</label></li>
                        </ul>
                    </div>
                    <span class="donation-choice-breaker">Or</span>
                    <div class="col-md-6 col-sm-6 donate-amount-option">
                        <h4>Enter your own</h4>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">$</span>
                            <input type="number" class="form-control">
                        </div>
                    </div>
               	</div>
      		</div>
      		<div class="modal-body">
       			<div class="row">
                	<div class="col-md-6 col-sm-6 donation-form-infocol">
                    	<h4>Address</h4>
                        <input type="text" class="form-control" placeholder="Address line 1">
                        <input type="text" class="form-control" placeholder="Address line 2">
       					<div class="row">
                			<div class="col-md-8 col-sm-8 col-xs-8">
                        		<input type="text" class="form-control" placeholder="State/City">
                            </div>
                			<div class="col-md-4 col-sm-4 col-xs-4">
                        		<input type="text" class="form-control" placeholder="Zipcode">
                            </div>
                    	</div>
       					<div class="row">
                			<div class="col-md-3 col-sm-3 col-xs-3">
                        		<label>Country</label>
                            </div>
                			<div class="col-md-9 col-sm-9 col-xs-9">
                                <select class="selectpicker">
                                    <option>United States</option>
                                    <option>Australia</option>
                                    <option>Netherlands</option>
                                </select>
                            </div>
                    	</div>
                    </div>
                	<div class="col-md-6 col-sm-6 donation-form-infocol">
                    	<h4>Personal info</h4>
       					<div class="row">
                			<div class="col-md-6 col-sm-6 col-xs-6">
                        		<input type="text" class="form-control" placeholder="First name">
                            </div>
                			<div class="col-md-6 col-sm-6 col-xs-6">
                        		<input type="text" class="form-control" placeholder="Last name">
                            </div>
                    	</div>
                        <input type="text" class="form-control" placeholder="Email address">
                        <input type="text" class="form-control" placeholder="Phone no.">
                        <label class="checkbox"><input type="checkbox"> Register me on this website</label>
                    </div>
                 </div>
      		</div>
      		<div class="modal-footer text-align-center">
        		<button type="button" class="btn btn-primary">Make your donation now</button>
                <div class="spacer-20"></div>
                <!--<p class="small">Vestibulum quam nisi, pretium a nibh sit amet, consectetur hendrerit mi. Aenean imperdiet lacus sit amet elit porta, et malesuada erat bibendum. Cras sed nunc massa. Quisque tempor dolor sit amet tellus malesuada, malesuada iaculis eros dignissim. Aenean vitae diam id lacus fringilla maximus. Mauris auctor efficitur nisl, non blandit urna fermentum nec. Vestibulum quam nisi, pretium a nibh sit amet, consectetur hendrerit mi.</p>-->
      		</div>
    	</div>
  	</div>
</div>

<div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" data-backdrop="static">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        	</div>
      		<div class="modal-body">
       			<div class="row">
                	<div class="col-md-6 col-sm-6 donation-form-infocol">
                    	<h4>Login</h4>
                        <input type="text" class="form-control" placeholder="Mobile No">
                        <input type="text" class="form-control" placeholder="Password">
                        <button type="button" class="btn btn-primary">Login now</button>
       					<!-- <div class="row">
                			<div class="col-md-8 col-sm-8 col-xs-8">
                        		<input type="text" class="form-control" placeholder="State/City">
                            </div>
                			<div class="col-md-4 col-sm-4 col-xs-4">
                        		<input type="text" class="form-control" placeholder="Zipcode">
                            </div>
                    	</div>
       					<div class="row">
                			<div class="col-md-3 col-sm-3 col-xs-3">
                        		<label>Country</label>
                            </div>
                			<div class="col-md-9 col-sm-9 col-xs-9">
                                <select class="selectpicker">
                                    <option>India</option>
                                    <option>USA</option>
                                    <option>UK</option>
                                </select>
                            </div>
                    	</div> -->
                    </div>
                	<div class="col-md-6 col-sm-6 donation-form-infocol">
                    	<h4>Register</h4>
       					<div class="row">
                			<!-- <div class="col-md-6 col-sm-6 col-xs-6">
                        		<input type="text" class="form-control" placeholder="First name">
                            </div>
                			<div class="col-md-6 col-sm-6 col-xs-6">
                        		<input type="text" class="form-control" placeholder="Last name">
                            </div> -->
							<div class="col-md-12 col-sm-12 col-xs-12">
                        		<input type="text" class="form-control" placeholder="Your Name" id="user_name">
                            </div>
                    	</div>
                        <!-- <input type="text" class="form-control" placeholder="Email address"> -->
                        <input type="text" class="form-control" placeholder="Phone no." maxlength="10" minlength="10" id="reg_mobile_num" onkeyup="sendOtp(this.value);">
                        <div id="div_reg_otp" style="display:none;">
							<input type="text" class="form-control" placeholder="6 digits" maxlength="6" minlength="6" id="input-otp" style="width: 28%;float:left;">
							<span id="countdown"></span>
							<div style="clear:both;"></div>
							<div class="col-sm-12" id="Resendbtn">
								<a href="javascript:void(0);" id="button-resend-otp" onclick="resendOtp();">Resend OTP</a>
							</div>
						</div>
                        <button type="button" class="btn btn-primary" onclick="register_user();">Register now</button>
                        <!-- <label class="checkbox"><input type="checkbox"> Register me on this website</label> -->

                    </div>
                 </div>
      		</div>
      		<div class="modal-footer text-align-center">
        		
                <div class="spacer-20"></div>
                <!--<p class="small">Vestibulum quam nisi, pretium a nibh sit amet, consectetur hendrerit mi. Aenean imperdiet lacus sit amet elit porta, et malesuada erat bibendum. Cras sed nunc massa. Quisque tempor dolor sit amet tellus malesuada, malesuada iaculis eros dignissim. Aenean vitae diam id lacus fringilla maximus. Mauris auctor efficitur nisl, non blandit urna fermentum nec. Vestibulum quam nisi, pretium a nibh sit amet, consectetur hendrerit mi.</p>-->
      		</div>
    	</div>
  	</div>
</div>