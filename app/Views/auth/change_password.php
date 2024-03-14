<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 14/03/2024
 * Time: 15:29
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
                                    <h4 class="card-title">Ganti Password</h4>
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

                                <form class="form-horizontal" action="<?= base_url('auth/changepasswordact') ?>"
                                      method="post">

                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="password_old">Password Lama <span class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" name="password_old" id="password_old"
                                                   required maxlength="20" placeholder="Password Lama">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="password_new">Password Baru <span class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" name="password_new" id="password_new"
                                                   required maxlength="20" placeholder="Password Baru">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="password_new">Konfirmasi Password <span class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" name="password_confirm" id="password_confirm"
                                                   required maxlength="20" placeholder="Password Confirm">
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