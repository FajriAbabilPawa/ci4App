<?php 
// dd(session()->get())
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Profile</title>
    <?php echo $this->include('header.php'); echo $this->include('menu.php'); ?>
        <div class="container-login100">
            <div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
                
                <span style="text-align: center; color: red;font-size: x-large;"><?php if(session()->getFlashData("Success")) echo session()->getFlashData("Success"); ?></span>
                <span style="text-align: center; color: red;font-size: x-large;"><?php if(session()->getFlashData("Error")) echo session()->getFlashData("Error"); ?></span>
                <span class="login100-form-title p-b-32"> User Profile </span><br>
                <div style="float: center">
                    <img src="<?=$pfp?>" alt="Profile Image" width="40%" style="margin-left: 90px;">
                    
                    <br>  <br>
                    <?=session()->get('name')?></h4><br>
                    <h4>Email: <?=session()->get('email')?></h4><br>
                    <h4>Contact: <?=session()->get('phone_no')?></h4><br>
                </div>
                <div class="row">
                    <div class="col-md-12" style="height: 50px;font-size: 25px;">
                        <a href="<?=base_url('/updateprofile')?>" class="btn btn-info">Update Profile</a>
                        <a href="<?=base_url('/changepassword')?>" class="btn btn-danger">Delete My Account</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="height: 50px;font-size: 25px;">
                        <a href="<?=base_url('/changepassword')?>" class="btn btn-info">Change Password</a>
                    </div>
                </div>
            </div>
        </div>
    <?php echo $this->include('footer.php'); ?>