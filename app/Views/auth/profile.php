<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 14/03/2024
 * Time: 13:49
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
                                    <h4 class="card-title">Profil</h4>
                                </div>
                            </div>
                            <div class="iq-card-body">


                                <div class="form-group row">
                                    <label class="control-label col-sm-2 align-self-center mb-0"
                                           for="username">Username</label>

                                    <div class="col-sm-10"> :
                                        <?= $users['username'] ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-2 align-self-center mb-0"
                                           for="role_id">Role</label>

                                    <div class="col-sm-10"> :
                                        <?= $users['role_name'] ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-2 align-self-center mb-0"
                                           for="full_name">Nama Lengkap</label>

                                    <div class="col-sm-10"> :
                                        <?= $users['full_name'] ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-2 align-self-center mb-0"
                                           for="isactive">Aktif</label>

                                    <div class="col-sm-10"> :
                                        <?= ($users['isactive'] == 'Y') ? "<span class='badge badge-success'><i class='las la-check'></i></span>" : "<span class='badge badge-danger'><i class='las la-times'></i></span>" ?>
                                    </div>
                                </div>

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