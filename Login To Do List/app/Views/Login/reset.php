<?= $this->extend('Template/Layout') ?>

<?= $this->section('content') ?>

<div class="reset-container">

    <div class="reset-view row position-absolute top-50 start-50 translate-middle">
        <div class="reset-bg col-12 col-sm-6">

        </div>
        <div class="d-grid align-items-center col-12 col-sm-6">
            <form action="" method="post">
                <?php if (session()->getFlashdata('succesReset')) { ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->getFlashdata('succesReset') ?> <a class="text-decoration-none" href="/">Login</a>
                    </div>
                <?php } ?>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control <?= session()->getFlashdata('password') ? 'is-invalid' : '' ?>" id="exampleInputPassword1" name="password" value="<?= old('password') ? old('password') : '' ?>">
                    <?php if (session()->getFlashdata('password')) { ?>
                        <div id="validationServer03Feedback" class="invalid-feedback">
                           <?= session()->getFlashdata('password') ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword2" class="form-label">Ulangi Password</label>
                    <input type="password" class="form-control <?= session()->getFlashdata('retry_password') ? 'is-invalid' : '' ?>" id="exampleInputPassword2" name="retry_password" value="<?= old('retry_password') ? old('retry_password') : '' ?>">
                    <?php if (session()->getFlashdata('retry_password')) { ?>
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <?= session()->getFlashdata('retry_password') ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="mb-3 d-flex d-grid gap-2">
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    <button type="submit" class="btn btn-danger" name="batal">Batal</button>
                </div>
            </form>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
