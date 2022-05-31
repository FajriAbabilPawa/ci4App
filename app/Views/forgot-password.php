<?= $this->extend("layouts/app"); ?>

<?= $this->section("body"); ?>

<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <?php

                    ?>
                    <div class="card card-primary py-3 px-5">
                        <div class="card-header">
                            <h4><?= $title; ?></h4>
                        </div>

                        <?php if (session()->get('success')) :
                        ?>
                            <div class="alert alert-success" role="alert">
                                <?= session()->get('success') ?>
                                <br>
                                <a href="<?php echo base_url('login') ?>" class="mt-1 alert-link" onclick="loginActive()">Kembali ke halaman login?</a>
                            </div>
                        <?php endif; ?>

                        <div class="card-body">
                            <form method="POST" action="<?= base_url('forgot-password') ?>">
                                <?= csrf_field(); ?>
                                <?php if (isset($validation)) { ?>
                                    <div class="col-12">
                                        <div class="alert alert-danger" role="alert">
                                            <?= $validation->listErrors() ?>
                                            <?= session()->get('error') ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if (session()->get('error')) :
                                ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?= session()->get('error') ?>
                                        <br>
                                        <?php if (session()->get('error') === 'Email tidak terdaftar') : ?>
                                            <a href="<?php echo base_url('register') ?>" class="mt-1 alert-link" onclick="registerActive()">Create account</a>
                                        <?php endif ?>
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <input id="email" type="email" class="form-control" name="email" tabindex="1" placeholder="Email" value="<?php echo $email ?? '' ?>" required autofocus>
                                </div>

                                <div class="form-group my-3">
                                    <input class="btn btn-primary" type="submit" value="Send Link" name="Send">
                                </div>
                            </form>

                            <div class="mt-5 text-muted text-center">
                                Go back? <a href="<?= base_url('login'); ?>" onclick="loginActive()">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
</script>

<?= $this->endSection(); ?>