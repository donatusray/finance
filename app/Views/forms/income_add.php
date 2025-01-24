<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 01/04/2024
 * Time: 10:14
 */
echo view("partial/header");
?>
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <script src="<?= base_url('public/jquery-mask') ?>/jquery.mask.min.js"></script>
    <div class="wrapper">
        <?= view("partial/menu") ?>

        <!-- Page Content  -->
        <div id="content-page" class="content-page">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('incomes') ?>">Pemasukan</a></li>
                            <li class="breadcrumb-item active">Tambah Pemasukan</li>
                        </ol>
                        <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Tambah Pemasukan</h4>
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

                                <form class="form-horizontal" action="<?= base_url('income/insert') ?>" method="post">
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="income_title">Nama Pemasukan <span
                                                class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <input type="text" name="income_title" id="income_title"
                                                   value="<?= $inputs['income_title'] ?>"
                                                   class="form-control" placeholder="Nama Pemasukan" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="income_date">Tanggal Pemasukan <span
                                                class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <input type="date" name="income_date" id="income_date"
                                                   value="<?= date('Y-m-d') ?>"
                                                   class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="category_id">Kategori <span class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <select required name="category_id" id="category_id"
                                                    class="form-control select2">
                                                <option value="">Pilih Kategori</option>
                                                <?php
                                                foreach ($categories as $cat) {
                                                    $selected = "";
                                                    if ($cat['category_id'] == $inputs['category_id']) $selected = "selected";
                                                    echo "<option " . $selected . " value='" . $cat['category_id'] . "'>" . $cat['category_parent_name'] . " - " . $cat['category_name'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                            <input type="hidden" value="<?= $inputs['category_name'] ?>"
                                                   name="category_name" id="category_name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="account_id">Akun Pemasukan <span
                                                class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <select required name="account_id" id="account_id"
                                                    class="form-control select2">
                                                <option value="">Pilih Akun Pemasukan</option>
                                                <?php
                                                foreach ($accounts as $account) {
                                                    $selected = "";
                                                    if ($account['account_id'] == $inputs['account_id']) $selected = "selected";
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
                                                   class="form-control money"
                                                   value="<?= ($inputs['amount'] == null) ? '0' : $inputs['amount'] ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="income_description">Keterangan</label>

                                        <div class="col-sm-10">
                                            <textarea rows="2" name="income_description" id="income_description"
                                                      placeholder="Keterangan"
                                                      class="form-control"><?= $inputs['income_description'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="<?= base_url('income') ?>" class="btn iq-bg-danger">Kembali</a>
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
    </script>
<?php
echo view("partial/footer");
?>