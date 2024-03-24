<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 15/03/2024
 * Time: 18:45
 */
echo view("partial/header");
?>
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
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
                            <li class="breadcrumb-item"><a href="<?= base_url('categories') ?>">Kategori</a></li>
                            <li class="breadcrumb-item active">Edit Kategori</li>
                        </ol>
                        <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Edit Kategori</h4>
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

                                <form class="form-horizontal" action="<?= base_url('categories/update') ?>"
                                      method="post">
                                    <input type="hidden" name="category_id" id="category_id"
                                           value="<?= $inputs['category_id'] ?>">

                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="category_name">Nama Kategori <span
                                                class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="category_name"
                                                   id="category_name" value="<?= $inputs['category_name'] ?>"
                                                   required placeholder="Nama Kategori">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="category_type">Tipe <span class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <select name="category_type" id="category_type" class="form-control"
                                                    required>
                                                <option value="">--Pilih Kategori--</option>
                                                <option
                                                    value="INCOME" <?= ($inputs['category_type'] == "INCOME") ? "selected" : ""; ?>>
                                                    INCOME
                                                </option>
                                                <option
                                                    value="EXPENSE" <?= ($inputs['category_type'] == "EXPENSE") ? "selected" : "" ?>>
                                                    EXPENSE
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="category_description">Keterangan</label>

                                        <div class="col-sm-10">
                                            <textarea rows="2" name="category_description" id="category_description"
                                                      placeholder="Keterangan"
                                                      class="form-control"><?= $inputs['category_description'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="<?= base_url('categories') ?>" class="btn iq-bg-danger">Kembali</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
echo view("partial/footer");
?>