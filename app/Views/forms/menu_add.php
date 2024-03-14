<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 18/02/2024
 * Time: 01:55
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
                            <li class="breadcrumb-item"><a href="<?= base_url('menus') ?>">Menus</a></li>
                            <li class="breadcrumb-item active">Tambah Menu</li>
                        </ol>
                        <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Tambah Menu</h4>
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

                                <form class="form-horizontal" action="<?= base_url('menus/insert') ?>" method="post">
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="menu_name">Nama Menu <span class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="menu_name" id="menu_name"
                                                   required
                                                   placeholder="Nama Menu">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="menu_parent">Menu Parent</label>

                                        <div class="col-sm-10">
                                            <select name="menu_parent" id="menu_parent" class="form-control">
                                                <option value=""></option>
                                                <?php
                                                if (count($parents) > 0) {
                                                    foreach ($parents as $parent) {
                                                        echo "<option value='" . $parent['menu_id'] . "'>" . $parent['menu_name'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="menu_link">Menu Link <span class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="menu_link" id="menu_link"
                                                   required
                                                   placeholder="Link Menu">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="menu_icon">Icon</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="menu_icon" name="menu_icon"
                                                   placeholder="Icon Menu">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="menu_description">Keterangan</label>

                                        <div class="col-sm-10">
                                            <textarea rows="2" name="menu_description" id="menu_description"
                                                      placeholder="Keterangan"
                                                      class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0" for="menu_action">Isaction</label>

                                        <div class="col-sm-10">
                                            <input type="checkbox" name="menu_action"
                                                   id="menu_action">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0" for="menu_order">Urutan
                                            Menu <span class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <input type="text" name="menu_order" id="menu_order" required class="form-control"
                                                  />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="<?= base_url('menus') ?>" class="btn iq-bg-danger">Kembali</a>
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
<?php
echo view("partial/footer");
?>