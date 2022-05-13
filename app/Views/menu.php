<div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-6" style="height: 50px;word-spacing: 30px;font-size: 25px;">
                    <?php if(session()->get('LoggedUserData')){ ?>
                    <a href="<?=base_url('/profile')?>" class="btn btn-primary">Profile</a>
                    <a href="<?=base_url('/logout')?>" class="btn btn-primary">Logout</a>
                    <?php }else{ ?>
                    <a href="<?=base_url('/register')?>" class="btn btn-primary">Register</a>
                    <a href="<?=base_url('/login')?>" class="btn btn-primary">Login</a>
                    <?php } ?>
                </div>
                <div class="col-md-2"></div>
            </div>
© 2022 GitHub, Inc.
Terms
Privacy