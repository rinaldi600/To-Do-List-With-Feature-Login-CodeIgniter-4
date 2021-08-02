<?= $this->extend('Template/Layout') ?>

<?= $this->section('content') ?>
<div class="container-full-screen">
    <div class="navbar">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <form action="" method="post">
                                <button type="submit" class="bg-danger text-white border-0 p-2 rounded" name="submit">Log Out</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="cover">
        <div class="title d-grid align-content-center">
            <h1 class="text-center text-wrap">To Do List</h1>
            <p>Dengan memanfaatkan aplikasi, kamu tidak perlu lagi membawa kertas dan alat tulis
                lainnya ke mana pun kamu pergi. Selain itu, dengan bantuan teknologi,
                kamu juga bisa menikmati fitur sinkronisasi. Dengan begitu,
                kamu bisa membaca tugas-tugasmu baik di HP maupun di laptop saat bekerja.</p>
        </div>
    </div>
    <div class="content">
        <div class="message-notifications mx-auto mt-4">
            <?php if (session()->getFlashdata('deleteMessage')) { ?>
                <div class="delete-message alert alert-success" role="alert">
                   <?= session()->getFlashdata('deleteMessage') ?>
                </div>
            <?php } ?>
            <?php if (session()->getFlashdata('updateMessage')) { ?>
                <div class="delete-message alert alert-success" role="alert">
                    <?= session()->getFlashdata('updateMessage') ?>
                </div>
            <?php } ?>
            <?php if (session()->getFlashdata('createMessage')) { ?>
                <div class="delete-message alert alert-success" role="alert">
                    <?= session()->getFlashdata('createMessage') ?>
                </div>
            <?php } ?>
            <?php if (session()->getTempdata('expiredTime')) { ?>
                <div class="expired-time alert alert-success" role="alert">
                    <?= session()->getTempdata('expiredTime') ?>
                </div>
            <?php } ?>
        </div>
        <?php if (count($record) !== 0) { ?>
            <?php foreach ($record as $row) { ?>
                <div class="row list d-flex mt-5 mx-auto p-3 rounded-3">
                    <div class="col-xl-9 col-xxl-9 content">
                        <p class="lh-base align-middle mt-3"><?= $row["text"] ?></p>
                    </div>
                    <div class="col-xl-3 col-xxl-3 button d-flex align-items-center justify-content-center d-grid gap-2">
                        <form action="" method="post">
                            <input type="hidden" value="<?= $row["id"] ?>" name="_change">
                            <button class="border-0 bg-warning p-2 rounded" type="submit" name="change">Ubah</button>
                        </form>
                        <form action="" method="post">
                            <input type="hidden" value="<?= $row["id"] ?>" name="_delete">
                            <button onclick="return confirm('Yakin Ingin Dihapus')" class="border-0 bg-danger p-2 rounded text-white" type="submit" name="delete">Delete</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <h1 class="identifity text-center">Tidak Ada Catatan Apapun</h1>
        <?php } ?>
    </div>
    <div class="write">
        <form action="" method="post">
            <div class="row text mx-auto mt-5 rounded-3">
                <div class="col-xl-9 col-xxl-9">
                    <textarea class="form-control border-0" placeholder="New Notes" id="floatingTextarea2" name="valueText" style="height: 100px"><?= session()->getTempdata('dataChange') ? session()->getTempdata('dataChange') : '' ?></textarea>
                </div>
                <div class="col-xl-3 col-xxl-3 d-flex d-grid justify-content-center align-items-center gap-2">
                    <?php if (session()->getTempdata('dataChange')) { ?>
                        <input type="hidden" name="id" value="<?= session()->getTempdata('idChange') ?>">
                        <button type="submit" class="bg-success border-0 p-2 rounded text-white" name="ubah">Ubah</button>
                        <button type="submit" class="bg-warning border-0 p-2 rounded text-dark" name="cancel">Batal</button>
                    <?php } else { ?>
                        <button type="submit" class="bg-success border-0 p-2 rounded text-white" name="create">Tambah</button>
                    <?php } ?>
                </div>
            </div>
        </form>
    </div>
    <div class="empty-box">

    </div>
</div>
<?= $this->endSection() ?>
