<?= $this->extend('Template/Layout') ?>

<?= $this->section('content') ?>
    <div class="container position-absolute top-50 start-50 translate-middle">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 coverr">
<!--                <img src="/img/laura-chouette-6udWBRfr0Io-unsplash.jpg" class="img-fluid" alt="">-->
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <?php if (session()->getFlashdata('passwordWrong')) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?= session()->getFlashdata('passwordWrong') ?>
                    </div>
                <?php } ?>
                <?php if (session()->getFlashdata('usernameWrong')) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?= session()->getFlashdata('usernameWrong') ?>
                    </div>
                <?php } ?>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Username</label>
                        <input type="text" class="form-control <?= session()->getFlashdata('username') ? 'is-invalid' : '' ?>" id="exampleInputEmail1" name="username" value="<?= old('username') ? old('username') : '' ?>">
                        <div id="emailHelp" class="alert-text form-text">We'll never share your Username with anyone else.</div>
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <?= session()->getFlashdata('username') ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control <?= session()->getFlashdata('password') ? 'is-invalid' : '' ?>" id="exampleInputPassword1" name="password">
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <?= session()->getFlashdata('password')?>
                        </div>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="checkbox">
                        <label class="form-check-label" for="exampleCheck1">Keep Login</label>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Masuk</button>

                    <div class="mb-3 form-check mt-2">
                        <label class="form-check-label" for="exampleCheck1">Belum Punya Akun</label>
                        <a class="text-decoration-none" href="/login/signup">Daftar Sekarang</a>
                    </div>
                    <div class="mb-3 form-check mt-2">
                        <div class="row">
                            <div class="col-xxl-1 col-xl-1">
                                <img class="img-fluid" src="/img/password.png" alt="">
                            </div>
                            <div class="col-xxl-11 col-xl-11">
                                <a class="text-decoration-none" href="/login/forgot">Lupa Password</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>