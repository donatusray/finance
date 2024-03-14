<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 11/02/2024
 * Time: 11:21
 */
?>
<!-- Sidebar  -->
<div class="iq-sidebar">
    <div class="iq-navbar-logo d-flex justify-content-between">
        <a href="index.html" class="header-logo">
            <img src="images/logo.png" class="img-fluid rounded" alt="">
            <span>Finance</span>
        </a>

        <div class="iq-menu-bt align-self-center">
            <div class="wrapper-menu">
                <div class="main-circle"><i class="ri-menu-line"></i></div>
                <div class="hover-circle"><i class="ri-close-fill"></i></div>
            </div>
        </div>
    </div>
    <div id="sidebar-scrollbar">
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="iq-menu">
                <?php
                $_dataMenu = session()->get('akses_menu');
                echo $_dataMenu;
                ?>
            </ul>
        </nav>
        <div class="p-3"></div>
    </div>
</div>
<!-- TOP Nav Bar -->
<div class="iq-top-navbar">
    <div class="iq-navbar-custom">
        <nav class="navbar navbar-expand-lg navbar-light p-0">
            <div class="iq-menu-bt d-flex align-items-center">
                <div class="wrapper-menu">
                    <div class="main-circle"><i class="ri-menu-line"></i></div>
                    <div class="hover-circle"><i class="ri-close-fill"></i></div>
                </div>
                <div class="iq-navbar-logo d-flex justify-content-between ml-3">
                    <a href="index.html" class="header-logo">
                        <img src="images/logo.png" class="img-fluid rounded" alt="">
                        <span>FinDash</span>
                    </a>
                </div>
            </div>

            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-label="Toggle navigation">
                <i class="ri-menu-3-line"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto navbar-list">

                    <li class="nav-item nav-icon">
                        <a href="#" class="search-toggle iq-waves-effect bg-primary rounded">
                            <i class="ri-notification-line"></i>
                            <span class="bg-danger dots"></span>
                        </a>

                        <div class="iq-sub-dropdown">
                            <div class="iq-card shadow-none m-0">
                                <div class="iq-card-body p-0 ">
                                    <div class="bg-primary p-3">
                                        <h5 class="mb-0 text-white">all notifications
                                            <smaLl cLass="badge  badge-light float-right pt-1">4</small>
                                        </h5>
                                    </div>
                                    <a href="#" class="iq-sub-card">
                                        <div class="media align-items-center">
                                            <div class="">
                                                <img class="avatar-40 rounded" src="images/user/01.jpg" alt="">
                                            </div>
                                            <div class="media-body ml-3">
                                                <h6 class="mb-0 ">Emma Watson Barry</h6>
                                                <small class="float-right font-size-12">Just now</small>
                                                <p class="mb-0">95 MB</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="iq-sub-card">
                                        <div class="media align-items-center">
                                            <div class="">
                                                <img class="avatar-40 rounded" src="images/user/02.jpg" alt="">
                                            </div>
                                            <div class="media-body ml-3">
                                                <h6 class="mb-0 ">New customer is join</h6>
                                                <small class="float-right font-size-12">5 days ago</small>
                                                <p class="mb-0">Cyst Barry</p>
                                            </div>
                                        </div>
                                    </a>

                                </div>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
            <ul class="navbar-list">
                <li class="line-height">
                    <a href="#" class="search-toggle iq-waves-effect d-flex align-items-center">
                        <i class="la la-3x la-user-circle img-fluid rounded mr-3 text-warning"></i>
                        <!--                        <img src="-->
                        <? //= base_url('public') ?><!--/images/user/1.jpg" class="img-fluid rounded mr-3"-->
                        <!--                             alt="user">-->

                        <div class="caption">
                            <h6 class="mb-0 line-height"><?= session()->get('username') ?></h6>

                            <p class="mb-0"><?= session()->get('role_name') ?></p>
                        </div>
                    </a>

                    <div class="iq-sub-dropdown iq-user-dropdown">
                        <div class="iq-card shadow-none m-0">
                            <div class="iq-card-body p-0 ">
                                <div class="bg-primary p-3">
                                    <h5 class="mb-0 text-white line-height">Hello <?= session()->get('username') ?></h5>
                                    <span class="text-white font-size-12">Available</span>
                                </div>
                                <a href="<?= base_url('users/profile') ?>" class="iq-sub-card iq-bg-primary-hover">
                                    <div class="media align-items-center">
                                        <div class="rounded iq-card-icon iq-bg-primary">
                                            <i class="ri-file-user-line"></i>
                                        </div>
                                        <div class="media-body ml-3">
                                            <h6 class="mb-0 ">Profil Saya</h6>

                                            <p class="mb-0 font-size-12">Melihat profil detail aplikasi.</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="<?= base_url('users/usereditsingle') ?>"
                                   class="iq-sub-card iq-bg-primary-hover">
                                    <div class="media align-items-center">
                                        <div class="rounded iq-card-icon iq-bg-primary">
                                            <i class="ri-profile-line"></i>
                                        </div>
                                        <div class="media-body ml-3">
                                            <h6 class="mb-0 ">Edit Profil</h6>

                                            <p class="mb-0 font-size-12">Modifikasi profil.</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="<?= base_url('auth/changepassword') ?>"
                                   class="iq-sub-card iq-bg-primary-hover">
                                    <div class="media align-items-center">
                                        <div class="rounded iq-card-icon iq-bg-primary">
                                            <i class="ri-lock-line"></i>
                                        </div>
                                        <div class="media-body ml-3">
                                            <h6 class="mb-0 ">Ganti Password</h6>

                                            <p class="mb-0 font-size-12">Ganti password aplikasi.</p>
                                        </div>
                                    </div>
                                </a>

                                <div class="d-inline-block w-100 text-center p-3">
                                    <a class="bg-primary iq-sign-btn" id="clicklogout" href="<?= base_url('auth/logout') ?>"
                                       role="button">Sign out<i
                                            class="ri-login-box-line ml-2"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        if (sessionStorage.length == 0) {
            sessionStorage.clear();
            sessionStorage.setItem("menu-navsub", "1-1");
        }

        $(".menu-navsub").on('click', function () {
            sessionStorage.clear();
            const navsub = $(this).data('navsub');
            sessionStorage.setItem("menu-navsub", navsub);
        });

        if (sessionStorage.getItem("menu-navsub")) {
            var anavsub = sessionStorage.getItem("menu-navsub");
            var replaceNavSub = anavsub.split("-");
            $(".menu-nav").attr("aria-expanded", "false");
            $("#" + anavsub).addClass("active");
            $("#a" + replaceNavSub[0]).addClass('collapsed');
            $("#a" + replaceNavSub[0]).attr("aria-expanded", "true");
            $("#form" + replaceNavSub[0]).addClass('show');
            $("#" + replaceNavSub[0]).addClass("active");
        }
        $("#clicklogout").on('click',function(){
            sessionStorage.clear();
        });
    });
</script>
<!-- TOP Nav Bar END -->