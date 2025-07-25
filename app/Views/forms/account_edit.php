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
                            <li class="breadcrumb-item active">Edit Akun</li>
                        </ol>
                        <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Edit Akun</h4>
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

                                <form class="form-horizontal" action="<?= base_url('accounts/update') ?>" method="post">
                                    <input type="hidden" name="account_id" id="account_id"
                                           value="<?= $inputs['account_id'] ?>">

                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="account_name">Nama Akun <span class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="account_name"
                                                   id="account_name" value="<?= $inputs['account_name'] ?>"
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
                                               for="is_credit">Akun Paylater</label>

                                        <div class="col-sm-10">
                                            <input type="checkbox" name="is_credit" onclick="changePaylater(this)"
                                                   id="is_credit" <?= ($inputs['is_credit'] == '1') ? "checked" : "" ?>>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="account_description">Keterangan</label>

                                        <div class="col-sm-10">
                                            <textarea rows="2" name="account_description" id="account_description"
                                                      placeholder="Keterangan"
                                                      class="form-control"><?= $inputs['account_description'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="account_active">Aktif</label>

                                        <div class="col-sm-10">
                                            <input type="checkbox" name="account_active"
                                                   id="account_active" <?= ($inputs['account_active'] == 'Y') ? "checked" : "" ?>>
                                        </div>
                                    </div>
                                    <div class="form-group row form_paylater">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="credit_limit">Credit Limit</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control money" name="credit_limit"
                                                   id="credit_limit"
                                                   value="<?= ($account_credit['credit_limit'] == null) ? 0 : $account_credit['credit_limit'] ?>"
                                                   placeholder="Credit Limit">
                                        </div>
                                    </div>
                                    <div class="form-group row form_paylater">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="billing_date">Billing Date</label>

                                        <div class="col-sm-10">
                                            <select name="billing_date" id="billing_date"
                                                    class="form-control select2">
                                                <option value="NOW">Saat Transaksi</option>
                                                <?php
                                                for ($i = 1; $i <= 31; $i++) {
                                                    echo "<option value='" . $i . "'>" . $i . "</option>";
                                                }
                                                ?>
                                                <option value="END_MONTH">Akhir Bulan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row form_paylater">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="due_date">Jatuh Tempo</label>

                                        <div class="col-sm-10">
                                            <select name="due_date" id="due_date"
                                                    class="form-control select2">
                                                <?php
                                                for ($i = 1; $i <= 30; $i++) {
                                                    echo "<option value='" . $i . "'>" . $i . " Hari Setelah Billing Date</option>";
                                                }
                                                ?>
                                            </select>
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
        $(".select2").select2();

        var billingDate = "<?=$account_credit['billing_date']?>";
        var dueDate = "<?=$account_credit['due_date']?>";
        var isCredit = "<?=$account['is_credit']?>";

        $(document).ready(function () {
            var billingDateForm = $("#billing_date");
            var dueDateForm = $("#due_date");
            if (billingDate !== "") {
                billingDateForm.val(billingDate);
                billingDateForm.trigger('change');
            }
            if (dueDate !== "") {
                dueDateForm.val(dueDate);
                dueDateForm.trigger('change');
            }
            if (isCredit === "1") {
                $(".form_paylater").show();
            } else {
                $(".form_paylater").hide();
            }
        });


        function changePaylater(formx) {
            if (formx.checked) {
                $(".form_paylater").show();
            } else {
                $(".form_paylater").hide();
            }
        }

    </script>
<?php
echo view("partial/footer");
?>