<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 14/03/2024
 * Time: 15:24
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
                        <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Edit Profil</h4>
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
                                <?php
                                }
                                if (!empty(session()->getFlashdata('success'))) {
                                    echo '<div class="alert alert-success">';
                                    echo session()->getFlashdata('success');
                                    echo '</div>';
                                }

                                ?>

                                <form class="form-horizontal" action="<?= base_url('users/updatesingle') ?>"
                                      method="post">
                                    <input type="hidden" name="user_id" id="user_id" value="<?= $inputs['user_id'] ?>">

                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="username">Username <span class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="username" id="username"
                                                   readonly
                                                   required maxlength="10" value="<?= $inputs['username'] ?>"
                                                   placeholder="Username">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="role_id">Role <span class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <select name="role_id" id="role_id" class="form-control" required>
                                                <option value="">Pilih Role</option>
                                                <?php
                                                if (count($roles) > 0) {
                                                    foreach ($roles as $role) {
                                                        $selected = "";
                                                        if ($role['role_id'] == $inputs['role_id']) echo $selected = "selected";
                                                        echo "<option value='" . $role['role_id'] . "' " . $selected . ">" . $role['role_name'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="full_name">Nama Lengkap <span class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="full_name" id="full_name"
                                                   required value="<?= $inputs['full_name'] ?>"
                                                   placeholder="Nama Lengkap">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
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