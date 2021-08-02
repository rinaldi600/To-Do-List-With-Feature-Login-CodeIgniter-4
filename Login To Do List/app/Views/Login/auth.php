<?= $this->extend('Template/Layout') ?>

<?= $this->section('content') ?>
<div class="container-auth">
    <div class="auth-view position-absolute top-50 start-50 translate-middle">
        <div class="row">
            <div class="cover-auth col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">

            </div>
            <div class="d-grid align-items-center col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                <form action="/login/auth" method="post">
                    <?php if (session()->getTempdata('tokenAuth')) { ?>
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading">Token :</h4>
                            <p><?= session()->getTempdata('tokenAuth')  ?></p>
                            <hr>
                            <p class="mb-0">Berlaku Selama 4 Menit</p>
                        </div>
                    <?php } ?>
                    <div class="mb-3">
                        <label for="exampleInputToken" class="form-label">Masukkan Token</label>
                        <input type="text" class="form-control" id="exampleInputToken" name="token">
                        <div id="tokenHelp" class="form-text">We'll Update Token Previous</div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="next">Next</button>
                    <button type="submit" class="btn btn-danger" name="cancel">Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
