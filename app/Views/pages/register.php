<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>

<?php

$session = \Config\Services::session();
$validation = \Config\Services::validation();
//? Tempat Debug
// dd($session->get())

?>
<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                    <!-- <div class="login-brand">
                            <img src="<? //= base_url('template'); 
                                        ?>/assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
                        </div> -->

                    <?php

                    use App\Controllers\Register;

                    ?>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Register</h4>
                        </div>

                        <div class="ms-4 text-muted">
                            Already have an account? <a href="<?= base_url('login'); ?>">Login</a>
                        </div>

                        <div class="card-body">
                            <form method="POST">
                                <div class="form-group row">
                                    <div class="col-6">
                                        <label for="name">Full Name</label>
                                        <input id="name" type="text" class="form-control <?= ($validation->hasError('name')) ? 'is-invalid' : ''; ?>" name=" name" value="<?= $name ?>" autofocus><?php if ($validation->getError('name')) { ?>
                                            <div class='invalid-feedback mb-2'>
                                                <?= $error = $validation->getError('name'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-6">
                                        <label for="username">Username</label>
                                        <input id="username" type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" name="username" value="<?= $username ?>"><?php if ($validation->getError('username')) { ?>
                                            <div class='invalid-feedback mb-2'>
                                                <?= $error = $validation->getError('username'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- <div class="form-group col-6">
                                        <label for="phone_no">No. Telepon</label>
                                        <input type="tel" pattern="[0-9]{0-15}" id="phone_no" class="form-control">
                                    </div> -->
                                    <div class="form-group col-6">
                                        <label for="phone_no">Phone No</label>
                                        <input type="tel" pattern="[0-9]{0-15}" class="form-control <?= ($validation->hasError('phone_no')) ? 'is-invalid' : ''; ?>" name="phone_no" id="phone_no" value="<?= $phone_no ?>"><?php if ($validation->getError('phone_no')) { ?>
                                            <div class='invalid-feedback mb-2'>
                                                <?= $error = $validation->getError('phone_no'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" name="email" value="<?= $email ?>"><?php if ($validation->getError('email')) { ?>
                                            <div class='invalid-feedback mb-2'>
                                                <?= $error = $validation->getError('email'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-6">
                                        <label for="password" class="d-block">Password</label>
                                        <input id="password" type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" name="password" value="<?= $password ?>"><?php if ($validation->getError('password')) { ?>
                                            <div class='invalid-feedback mb-2'>
                                                <?= $error = $validation->getError('password'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="col-6">
                                        <label for="password_confirm" class="d-block">Confirm Password</label>
                                        <input id="password_confirm" type="password" class="form-control <?= ($validation->hasError('password_confirm')) ? 'is-invalid' : ''; ?>" name="password_confirm" value="<?= $password_confirm ?>"><?php if ($validation->getError('password_confirm')) { ?>
                                            <div class='invalid-feedback mb-2'>
                                                <?= $error = $validation->getError('password_confirm'); ?>
                                            </div>
                                        <?php } ?>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block my-2">
                                        Register
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- <div class="simple-footer">
                            Copyright &copy; Stisla 2018
                        </div> -->
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection() ?>