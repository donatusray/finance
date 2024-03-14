<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 24/02/2024
 * Time: 15:32
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

                                <form class="form-horizontal" action="<?= base_url('menus/update') ?>" method="post">
                                    <input type="hidden" name="menu_id" id="menu_id" value="<?= $inputs['menu_id'] ?>"/>

                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="menu_name">Nama Menu <span class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="menu_name" id="menu_name"
                                                   required value="<?= $inputs['menu_name'] ?>"
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
                                                        $selected = "";
                                                        if ($parent['menu_id'] == $inputs['menu_parent']) echo $selected = "selected";
                                                        echo "<option value='" . $parent['menu_id'] . "' " . $selected . ">" . $parent['menu_name'] . "</option>";
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
                                                   required value="<?= $inputs['menu_link'] ?>"
                                                   placeholder="Link Menu">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="menu_icon">Icon</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="menu_icon" name="menu_icon"
                                                   value="<?= $inputs['menu_icon'] ?>"
                                                   placeholder="Icon Menu">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0" for="menu_action">Isaction</label>

                                        <div class="col-sm-10">
                                            <input type="checkbox" name="menu_action"
                                                   id="menu_action" <?= ($inputs['menu_action'] == 'Y') ? "checked" : "" ?>>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0" for="menu_order">Urutan
                                            Menu <span class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <input type="text" name="menu_order" id="menu_order" class="form-control"
                                                   value="<?= $inputs['menu_order'] ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="menu_description">Keterangan</label>

                                        <div class="col-sm-10">
                                            <textarea rows="2" name="menu_description" id="menu_description"
                                                      placeholder="Keterangan"
                                                      class="form-control"><?= $inputs['menu_description'] ?></textarea>
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