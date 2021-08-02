<?= $this->extend('Template/Layout') ?>

<?= $this->section('content') ?>

    <div class="container position-absolute top-50 start-50 translate-middle">
        <div class="row">
            <div class="col-xl-6 col-xxl-6 col-lg-6 col-md-6">
                <img class="img-fluid" src="/img/corinne-kutz-eeqFjT6q_sQ-unsplash.jpg" alt="">
            </div>
            <div class="col-xl-6 col-xxl-6 col-lg-6 col-md-6">
                <?php if (session()->getFlashdata('login')) { ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->getFlashdata('login') ?> <a href="/">Silahkan Login</a>
                    </div>
                <?php } ?>
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="text" class="form-control <?= session()->getFlashdata('email') ? 'is-invalid' : '' ?>" id="exampleInputEmail1" name="email" value="<?= old('email') ? old('email') : '' ?>">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <?= session()->getFlashdata('email') ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control <?= session()->getFlashdata('username') ? 'is-invalid' : '' ?>" id="username" name="username" value="<?= old('username') ? old('username') : '' ?>">
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <?= session()->getFlashdata('username') ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control <?= session()->getFlashdata('password') ? 'is-invalid' : '' ?>" id="password" name="password">
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <?= session()->getFlashdata('password') ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control <?= session()->getFlashdata('confirm_password') ? 'is-invalid' : '' ?>" id="confirm_password" name="confirm_password">
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <?= session()->getFlashdata('confirm_password') ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Daftar</button>
                    <button type="submit" class="btn btn-danger" name="cancel">Batal</button>
                </form>
            </div>
        </div>
    </div>


<?= $this->endSection() ?>
