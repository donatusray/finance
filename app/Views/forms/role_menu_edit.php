<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 05/03/2024
 * Time: 11:39
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
                            <li class="breadcrumb-item"><a href="<?= base_url('roles') ?>">Roles</a></li>
                            <li class="breadcrumb-item active">Setting Menu</li>
                        </ol>
                        <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Setting Role Menu</h4>
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

                                <form class="form-horizontal" action="<?= base_url('rolemenu/insert') ?>" method="post">
                                    <input type="hidden" name="role_id" id="role_id" value="<?= $inputs['role_id'] ?>"/>

                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="role_name">Nama Role <span class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <input type="hidden" name="role_id" id="role_id"
                                                   value="<?= $role['role_id'] ?>"/>
                                            <input type="text" class="form-control" name="role_name" id="role_name"
                                                   required value="<?= $role['role_name'] ?>" readonly
                                                   placeholder="Nama Role">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="role_name">Menus</label>

                                        <div class="col-sm-10">
                                            <?php
                                            if (count($menus) > 0) {
                                                foreach ($menus as $menu) {
                                                    $checked = "";
                                                    if ($menu['menu_id_role'] == $menu['menu_id']) $checked = "checked";
                                                    echo "<input type='checkbox' name='menu_id[]' ".$checked." value='" . $menu['menu_id'] . "' id='menu_id' for='menu_id' /> " . $menu['menu_order'] . " - " . $menu['menu_name'] . "<br>";
                                                }
                                            }
                                            ?>
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="<?= base_url('roles') ?>" class="btn iq-bg-danger">Kembali</a>
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