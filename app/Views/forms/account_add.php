<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 08/03/2024
 * Time: 14:43
 */
echo view("partial/header");
?>
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- MASK -->
    <script src="<?= base_url('public/jquery-mask') ?>/jquery.mask.min.js"></script>
    <!-- loader END -->
    <!-- Wrapper Start -->
    <div class="wrapper">
        <?= view("partial/menu") ?>

        <!-- Page Content  -->
        <div id="content-page" class="content-page">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('accounts') ?>">Akun</a></li>
                            <li class="breadcrumb-item active">Tambah Akun</li>
                        </ol>
                        <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Tambah Akun</h4>
                                </div>
                            </div>
                            <div class="iq-card-body">

                                <?php
                                $inputs = session()->getFlashdata('inputs');
                                $errors = session()->getFlashdata('errors');
                                if (!empty($errors)) {
                                    ?>
                                    <div class="alert alert-danger" role="alert">
                                        Whoops! Ada kesalahan saat input data, yaitu:
                                        <ul>
                                            <?php foreach ($errors as $error) : ?>
                                                <li><?php echo esc($error) ?></li>
                                            <?php endforeach ?>
                                        </ul>
                                    </div>
                                <?php } ?>

                                <form class="form-horizontal" action="<?= base_url('accounts/insert') ?>" method="post">
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="account_name">Nama Akun <span class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="account_name"
                                                   id="account_name"
                                                   required placeholder="Nama Akun">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="account_income">Akun Pemasukan</label>

                                        <div class="col-sm-10">
                                            <input type="checkbox" name="account_income"
                                                   id="account_income" <?= ($inputs['account_income'] == 'Y') ? "checked" : "" ?>>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="account_expense">Akun Pengeluaran</label>

                                        <div class="col-sm-10">
                                            <input type="checkbox" name="account_expense"
                                                   id="account_expense" <?= ($inputs['account_expense'] == 'Y') ? "checked" : "" ?>>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="account_limit">Limit</label>

                                        <div class="col-sm-10">
                                            <input type="text" name="account_limit" id="account_limit"
                                                   class="form-control money" value="0" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="account_description">Keterangan</label>

                                        <div class="col-sm-10">
                                            <textarea rows="2" name="account_description" id="account_description"
                                                      placeholder="Keterangan" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="<?= base_url('accounts') ?>" class="btn iq-bg-danger">Kembali</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Wrapper END -->
    <script type="text/javascript">
        $('.money').mask('000,000,000,000,000', {reverse: true});
    </script>
<?php
echo view("partial/footer");
?>