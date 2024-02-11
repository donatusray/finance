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
                <li>
                    <a href="#dashboard" class="iq-waves-effect" data-toggle="collapse" aria-expanded="false"><span
                            class="ripple rippleEffect"></span><i
                            class="las la-home iq-arrow-left"></i><span>Dashboard</span><i
                            class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                    <ul id="dashboard" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="index.html"><i class="las la-laptop-code"></i>Monitoring Keuangan</a></li>

                    </ul>
                </li>


                <li>
                    <a href="#userinfo" class="iq-waves-effect" data-toggle="collapse" aria-expanded="false"><span
                            class="ripple rippleEffect"></span><i
                            class="las la-user-tie iq-arrow-left"></i><span>Pengaturan</span><i
                            class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                    <ul id="userinfo" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle" style="">
                        <li><a href="profile.html"><i class="las la-id-card-alt"></i>Role</a></li>
                        <li><a href="user-list.html"><i class="las la-th-list"></i>Daftar Pengguna</a></li>
                        <li><a href="form-wizard-vertical.html"><i class="ri-anticlockwise-line"></i>Organisasi</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#ui-elements" class="iq-waves-effect collapsed" data-toggle="collapse"
                       aria-expanded="false"><i
                            class="lab la-elementor iq-arrow-left"></i><span>Master Data</span><i
                            class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                    <ul id="ui-elements" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="ui-colors.html"><i class="las la-palette"></i>Akun</a></li>
                        <li><a href="ui-typography.html"><i class="las la-keyboard"></i>Kategori</a></li>
                        <li><a href="ui-alerts.html"><i class="las la-tag"></i>Budget</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#forms" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i
                            class="lab la-wpforms iq-arrow-left"></i><span>Transaksi</span><i
                            class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                    <ul id="forms" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="form-layout.html"><i class="las la-book"></i>Pemasukan</a></li>
                        <li><a href="form-validation.html"><i class="las la-edit"></i>Pengeluaran</a></li>
                        <li><a href="form-switch.html"><i class="las la-toggle-off"></i>Transfer</a></li>
                        <li><a href="form-chechbox.html"><i class="las la-check-square"></i>Mutasi</a></li>
                    </ul>
                </li>
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
                        <img src="<?= base_url('public') ?>/images/user/1.jpg" class="img-fluid rounded mr-3"
                             alt="user">

                        <div class="caption">
                            <h6 class="mb-0 line-height">Barry Tech</h6>

                            <p class="mb-0">Manager</p>
                        </div>
                    </a>

                    <div class="iq-sub-dropdown iq-user-dropdown">
                        <div class="iq-card shadow-none m-0">
                            <div class="iq-card-body p-0 ">
                                <div class="bg-primary p-3">
                                    <h5 class="mb-0 text-white line-height">Hello Barry Tech</h5>
                                    <span class="text-white font-size-12">Available</span>
                                </div>
                                <a href="profile.html" class="iq-sub-card iq-bg-primary-hover">
                                    <div class="media align-items-center">
                                        <div class="rounded iq-card-icon iq-bg-primary">
                                            <i class="ri-file-user-line"></i>
                                        </div>
                                        <div class="media-body ml-3">
                                            <h6 class="mb-0 ">My Profile</h6>

                                            <p class="mb-0 font-size-12">View personal profile details.</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="profile-edit.html" class="iq-sub-card iq-bg-primary-hover">
                                    <div class="media align-items-center">
                                        <div class="rounded iq-card-icon iq-bg-primary">
                                            <i class="ri-profile-line"></i>
                                        </div>
                                        <div class="media-body ml-3">
                                            <h6 class="mb-0 ">Edit Profile</h6>

                                            <p class="mb-0 font-size-12">Modify your personal details.</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="account-setting.html" class="iq-sub-card iq-bg-primary-hover">
                                    <div class="media align-items-center">
                                        <div class="rounded iq-card-icon iq-bg-primary">
                                            <i class="ri-account-box-line"></i>
                                        </div>
                                        <div class="media-body ml-3">
                                            <h6 class="mb-0 ">Account settings</h6>

                                            <p class="mb-0 font-size-12">Manage your account parameters.</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="privacy-setting.html" class="iq-sub-card iq-bg-primary-hover">
                                    <div class="media align-items-center">
                                        <div class="rounded iq-card-icon iq-bg-primary">
                                            <i class="ri-lock-line"></i>
                                        </div>
                                        <div class="media-body ml-3">
                                            <h6 class="mb-0 ">Privacy Settings</h6>

                                            <p class="mb-0 font-size-12">Control your privacy parameters.</p>
                                        </div>
                                    </div>
                                </a>

                                <div class="d-inline-block w-100 text-center p-3">
                                    <a class="bg-primary iq-sign-btn" href="sign-in.html" role="button">Sign out<i
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
<!-- TOP Nav Bar END -->