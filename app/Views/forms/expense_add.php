<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 02/04/2024
 * Time: 10:53
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
    <!--    <!-- daterangepicker -->-->
    <!--    <script src="--><?php //echo base_url('public/moment'); ?><!--/moment.min.js"></script>-->
    <!--    <script src="--><?php //echo base_url('public/daterangepicker'); ?><!--/daterangepicker.js"></script>-->
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
                            <li class="breadcrumb-item"><a href="<?= base_url('expense') ?>">Pengeluaran</a></li>
                            <li class="breadcrumb-item active">Tambah Pengeluaran</li>
                        </ol>
                        <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Tambah Pengeluaran</h4>
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

                                <form class="form-horizontal" action="<?= base_url('expense/insert') ?>" method="post">
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="expense_title">Nama Pengeluaran <span class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <input type="text" name="expense_title" id="expense_title"
                                                   class="form-control" placeholder="Nama Pengeluaran" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="expense_date">Tanggal Pemasukan <span
                                                class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <input type="date" name="expense_date" id="expense_date" value="<?=date('Y-m-d')?>"
                                                   class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="category_id">Kategori <span class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <select required name="category_id" id="category_id" class="form-control"
                                                    onchange="changeSelCategoryId()">
                                                <option value="">Pilih Kategori</option>
                                                <?php
                                                foreach ($categories as $cat) {
                                                    echo "<option value='" . $cat['category_id'] . "'>" . $cat['category_name'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                            <input type="hidden" name="category_name" id="category_name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="account_id">Akun Pengeluaran <span
                                                class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <select required name="account_id" id="account_id" class="form-control">
                                                <option value="">Pilih Akun Pengeluaran</option>
                                                <?php
                                                foreach ($accounts as $account) {
                                                    echo "<option value='" . $account['account_id'] . "'>" . $account['account_name'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="amount">Nominal <span class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <input type="text" name="amount" id="amount"
                                                   class="form-control money" value="0" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="income_description">Keterangan</label>

                                        <div class="col-sm-10">
                                            <textarea rows="2" name="expense_description" id="expense_description"
                                                      placeholder="Keterangan" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="<?= base_url('expense') ?>" class="btn iq-bg-danger">Kembali</a>
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

        function changeSelCategoryId() {
            var textCategoryId = $("#category_id option:selected").text();
            $("#category_name").val(textCategoryId);
        }
    </script>
<?php
echo view("partial/footer");
?>