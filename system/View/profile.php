<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Profile</title>
    <?php include('header.php'); include('menu.php'); ?>
        <div class="container-login100">
            <div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
                
                <span style="text-align: center; color: red;font-size: x-large;"></span>
                <span style="text-align: center; color: red;font-size: x-large;"></span>
                <span class="login100-form-title p-b-32"> User Profile </span><br>
                <div style="float: center">
                    <img src="<?=base_url('assets/images.jpg')?>" alt="Profile Image" width="40%" style="margin-left: 90px;">
                    <br>  <br>
                    <h4>Name: </h4><br>
                    <h4>Email: </h4><br>
                    <h4>Contact: </h4><br>
                </div>
                <div class="row">
                    <div class="col-md-12" style="height: 50px;font-size: 25px;">
                        <a href="" class="btn btn-info">Update Profile</a>
                        <a href="" class="btn btn-danger">Delete My Account</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="height: 50px;font-size: 25px;">
                        <a href="" class="btn btn-info">Change Password</a>
                    </div>
                </div>
            </div>
        </div>
    <?php include('footer.php'); ?>

<!-- <!DOCTYPE html>
<html debug=false>
<head>
    <title>User Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body>
    <div class="container" style="margin-top: 100px">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1><u>User Profile</u></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"> </div>
            <div class="col-md-4">
                <img src="<?=base_url('assets/images.jpg')?>" width="40%" style="margin-left: 40px">
                <h4>Name: </h4>
                <h4>Email: </h4>
                <h4>Contact: </h4>
            </div>
            <div class="col-md-4"> </div>
        </div>
    </div>
</body>
</html> -->