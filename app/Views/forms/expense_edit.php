<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 02/04/2024
 * Time: 11:08
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
                            <li class="breadcrumb-item active">Ubah Pengeluaran</li>
                        </ol>
                        <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Ubah Pengeluaran</h4>
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

                                <form class="form-horizontal" action="<?= base_url('expense/update') ?>" method="post">
                                    <input type="hidden" name="id" id="id" value="<?= $expense['id'] ?>"/>

                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="expense_title">Nama Pengeluaran <span
                                                class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <input type="text" name="expense_title" id="expense_title"
                                                   value="<?= $inputs['expense_title'] ?>"
                                                   class="form-control" placeholder="Nama Pengeluaran" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="expense_date">Tanggal Pengeluaran <span
                                                class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <input type="date" name="expense_date" id="expense_date"
                                                   value="<?= date('Y-m-d', strtotime($inputs['expense_date'])) ?>"
                                                   class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="category_id">Kategori <span class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <select required name="category_id" id="category_id" class="form-control select2"
                                                    onchange="changeSelCategoryId()">
                                                <option value="">Pilih Kategori</option>
                                                <?php
                                                foreach ($categories as $cat) {
                                                    $selected = "";
                                                    if ($cat['category_id'] == $inputs['category_id']) {
                                                        $selected = "selected";
                                                    }
                                                    echo "<option " . $selected . " value='" . $cat['category_id'] . "'>" . $cat['category_parent_name'] . " - " . $cat['category_name'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                            <input type="hidden" name="category_name" id="category_name"
                                                   value="<?= $inputs['category_name'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="account_id">Akun Pengeluaran <span
                                                class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <select required name="account_id" id="account_id" class="form-control"
                                                    readonly="true">
                                                <?php
                                                foreach ($accounts as $account) {
                                                    if ($account['account_id'] != $inputs['account_id']) {
                                                        continue;
                                                    }
                                                    $selected = "selected";
                                                    echo "<option " . $selected . " value='" . $account['account_id'] . "'>" . $account['account_name'] . "</option>";
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
                                                   class="form-control money" value="<?= $inputs['amount'] ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="expense_description">Keterangan</label>

                                        <div class="col-sm-10">
                                            <textarea rows="2" name="expense_description" id="expense_description"
                                                      placeholder="Keterangan"
                                                      class="form-control"><?= $inputs['expense_description'] ?></textarea>
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
        $(".select2").select2();

        function changeSelCategoryId() {
            var textCategoryId = $("#category_id option:selected").text();
            $("#category_name").val(textCategoryId);
        }
    </script>
<?php
echo view("partial/footer");
?>