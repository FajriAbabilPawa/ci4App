<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
            <div class="panel panel-primary">
                <div class="panel-heading">Home</div>
                <div class="panel-body">
                    <h1>
                        <?php if (session()->get('role') == "admin") {
                            echo "Selamat Datang" . ' ' . session()->get('username');
                        } elseif (session()->get('role') == "member") {
                            echo "Selamat Datang" . ' ' . session()->get('username');
                        } else {
                            echo 'Selamat datang tamu, silahkan login';
                        } ?>
                    </h1>
                    <h3><a href="<?= site_url('login') ?>">Login</a></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>