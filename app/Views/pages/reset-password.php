<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>

<main role="main" class="container">

    <div class="container my-5">
        <div class="row">
            <div class="col-sm-6 offset-sm-3">
                <div class="card">
                    <?php if (null != session()->getTempdata('expired') || session()->getTempdata('not-found')) : ?>
                        <h2 class="card-header">Sorry, the link is <?php echo session()->getTempdata('expired') ?? session()->get('not-found') ?></h2>
                        <div class="card-body">
                            <a href="<?php echo base_url('forgot-password') ?>">Try filling this form and check your email again</a>
                        <?php else : ?>
                            <h2 class="card-header">Reset Your Password</h2>
                            <div class="card-body">

                                <!-- <?php if (isset($validation)) : ?> -->
                                <div class="alert alert-danger d-flex align-items-center" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                                        <use xlink:href="#exclamation-triangle-fill" />
                                    </svg>
                                    <div>
                                        <?= $validation->listErrors() ?>
                                    </div>
                                </div>
                                <!-- <?php endif ?> -->

                                <p>Enter the code you received via email, your email address, and your new password.</p>

                                <form action="<?= base_url('reset-password') . '/' . $slug ?>" method="post" abineguid="7E65546795BF4A7E98AB260F4019436E">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="csrf_test_name" value="0f55076ee794a58889968501ebf76fcd">
                                    <div class="form-group">
                                        <label for="token">Token</label>
                                        <input type="text" class="form-control " name="token" placeholder="Token" value="<?php echo $token ?? '' ?>">
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control " name="user" aria-describedby="emailHelp" placeholder="Email" value="<?php echo $user ?? '' ?>">
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>

                                    <br>

                                    <div class="form-group">
                                        <label for="password">New Password</label>
                                        <input type="password" class="form-control " name="password">
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="pass_confirm">Repeat New Password</label>
                                        <input type="password" class="form-control " name="pass_confirm">
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>

                                    <br>

                                    <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                                </form>
                            </div>
                        <?php endif ?>
                        </div>
                </div>
            </div>
        </div>

</main>

<?= $this->endSection() ?>