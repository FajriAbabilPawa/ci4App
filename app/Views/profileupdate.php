<!DOCTYPE html>
<html lang="en">
<head>
	<title>Update User</title>
	<?php include('header.php'); ?>
		<div class="container-login100">
			<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
				<span style="text-align: center; color: red;font-size: x-large;"></span>
				<!-- <?//php echo form_open_multipart('users/profileupdate') ?> -->
				<form class="login100-form validate-form flex-sb flex-w" action="<?=base_url('profileupdate')?>" method="post" enctype="multipart/form-data">
					<span class="login100-form-title p-b-32"> Update User </span>
				<?php echo $error ?? '' ?> <br>
					<?php
					if (isset($ErrorData)) {
						foreach ($ErrorData as $key => $k ) {
							echo $k . '<br>' ?? '' ;
						} 
					}
					?>
					<div>
						<p class="txt1 p-b-11"> Name </p>
						<div class="wrap-input100 validate1-input m-b-36" data-validate="Username is required">
							<input class="input100" type="text" name="name" value="<?= $name ?? session()->get('name') ?>">
							<span class="focus-input100"></span>
							<span><?php if(null !== (session()->getFlashData('name'))) { echo session()->getFlashData('name');} ?></span>
						</div>
					</div>	

					<div>
						<span class="txt1 p-b-11"> Contact </span>
						<div class="wrap-input100 validate1-input m-b-36" data-validate="Contact is required">
							<input class="input100" type="number" name="contact" value="<?= $contact ?? session()->get('phone_no') ?>">
							<span class="focus-input100"></span>						
							<span><?php if(null !== (session()->getFlashData("contact"))) echo session()->getFlashData("contact"); ?></span>
						</div>
					</div>
                     
					<div>
						<span class="txt1 p-b-11"> Profile Image </span>
						<div class="wrap-input100 validate1-input m-b-36" data-validate="Profile is required">
							<input class="input100" type="file" name="profile_img" value="">
							<span class="focus-input100"></span>
							<span><?php if(null !== (session()->getFlashData("profile_img"))) echo session()->getFlashData("profile_img"); ?></span>
						</div>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn"> Update </button>
					</div>
				</form>
			</div>
		</div>
	
    <?php include('footer.php'); ?>