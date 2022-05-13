<!DOCTYPE html>
<html lang="en">
<head>
	<title>Update User</title>
	<?php include('header.php'); include('menu.php'); ?>
		<div class="container-login100">
			<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
				<span style="text-align: center; color: red;font-size: x-large;"><?php if(session()->getFlashData("Error")) echo session()->getFlashData("Error"); ?></span>
				<form class="login100-form validate-form flex-sb flex-w" action="<?=base_url('updatepassword')?>" method="post" enctype="multipart/form-data">
					<span class="login100-form-title p-b-32"> Change Passsword </span>
					<span class="txt1 p-b-11">Old Password </span>
					<div class="wrap-input100 validate1-input m-b-12" data-validate="Password is required">
						<!-- <span class="btn-show-pass">
							<i class="fa fa-eye"></i>
						</span> -->
						<input class="input100" type="password" name="oldpassword">
						<span class="focus-input100"></span>	
						<span></span>					
					</div>
					<span class="txt1 p-b-11">New Password </span>
					<div class="wrap-input100 validate1-input m-b-12" data-validate="Password is required">
						<!-- <span class="btn-show-pass">
							<i class="fa fa-eye"></i>
						</span> -->
						<input class="input100" type="password" name="password">
						<span class="focus-input100"></span>	
						<span></span>					
					</div>

					<span class="txt1 p-b-11"> Confirm New Password </span>
					<div class="wrap-input100 validate1-input m-b-12" data-validate="Password is required">
						<input class="input100" type="password" name="confirm_password">
						<span class="focus-input100"></span>
						<span></span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn"> Update </button>
					</div>
				</form>
			</div>
		</div>
	
    <?php include('footer.php'); ?>