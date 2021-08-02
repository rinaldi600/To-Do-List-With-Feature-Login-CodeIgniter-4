<?= $this->extend('Template/Layout') ?>

<?= $this->section('content') ?>

    <div class="forgot-view">

        <div class="forgot-content row position-absolute top-50 start-50 translate-middle">

            <div class="cover-forgot col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
<!--                IMAGE COVER-->
            </div>

            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 d-grid align-items-center">
                <form method="post" action="">
                    <div class="mb-3">
                        <?php if (session()->getFlashdata('emailNotFound')) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?= session()->getFlashdata('emailNotFound') ?>
                            </div>
                         <?php } ?>
                        <label for="exampleInputEmail1" class="form-label">Masukkan Email Address</label>
                        <input type="text" class="form-control <?= session()->getFlashdata('emailAuth') ? 'is-invalid' : '' ?>" id="exampleInputEmail1" name="emailAuth" value="<?= old('emailAuth') ? old('emailAuth') : '' ?>">
                        <div id="emailHelp" class="form-text">Untuk Mendapatkan Token Auth</div>
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <?= session()->getFlashdata('emailAuth') ?>
                        </div>
                    </div>
                    <div class="mb-3 d-flex d-grid gap-2">
                        <button type="submit" class="btn btn-primary" name="next">Selanjutnya</button>
                        <button type="submit" class="btn btn-danger" name="cancel">Batal</button>
                    </div>
                </form>
            </div>

        </div>

    </div>

<?= $this->endSection() ?>
