<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 12/02/2024
 * Time: 14:01
 */
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Finance Manager - Donatus Ray</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url('public') ?>/images/favicon.ico"/>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('public') ?>/css/bootstrap.min.css">
    <!-- Typography CSS -->
    <link rel="stylesheet" href="<?= base_url('public') ?>/css/typography.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="<?= base_url('public') ?>/css/style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="<?= base_url('public') ?>/css/responsive.css">
</head>
<body>
<!-- loader Start -->
<div id="loading">
    <div id="loading-center">
    </div>
</div>
<!-- loader END -->
<!-- Sign in Start -->
<section class="sign-in-page">
    <div id="container-inside">
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
        <div class="cube"></div>
    </div>
    <div class="container p-0">
        <div class="row no-gutters height-self-center">
            <div class="col-sm-12 align-self-center bg-primary rounded">
                <div class="row m-0">
                    <div class="col-md-5 bg-white sign-in-page-data">
                        <div class="sign-in-from">
                            <h1 class="mb-0 text-center">Login</h1>

                            <p class="text-center text-dark">App Finance Management</p>
                            <?php
                            $error_login = session()->getFlashdata('error_login');
                            if    (!empty($error_login)) {
                                echo '<span class="alert-danger">' . $error_login . '</span>';
                            }
                            ?>


                            <form class="mt-4" method="post" action="<?=base_url('auth/loginprocess')?>">
                                <div class="form-group">
                                    <label for="uname">Username</label>
                                    <input type="text" class="form-control mb-0" id="uname" name="uname" maxlength="20"
                                           placeholder="Enter username">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control mb-0" id="pwuse" name="pwuse"
                                           maxlength="15"
                                           placeholder="Password">
                                </div>
                                <div class="sign-info text-center">
                                    <button type="submit" class="btn btn-primary d-block w-100 mb-2">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4 text-center sign-in-page-image">
                        <div class="sign-in-detail text-white"><img
                                src="<?= base_url('public') ?>/images/logo_depan_2.png" class="img-fluid"
                                alt="logo">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Sign in END -->

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="<?= base_url('public') ?>/js/jquery.min.js"></script>
<script src="<?= base_url('public') ?>/js/popper.min.js"></script>
<script src="<?= base_url('public') ?>/js/bootstrap.min.js"></script>
<!-- Appear JavaScript -->
<script src="<?= base_url('public') ?>/js/jquery.appear.js"></script>
<!-- Countdown JavaScript -->
<script src="<?= base_url('public') ?>/js/countdown.min.js"></script>
<!-- Counterup JavaScript -->
<script src="<?= base_url('public') ?>/js/waypoints.min.js"></script>
<script src="<?= base_url('public') ?>/js/jquery.counterup.min.js"></script>
<!-- Wow JavaScript -->
<script src="<?= base_url('public') ?>/js/wow.min.js"></script>
<!-- Apexcharts JavaScript -->
<script src="<?= base_url('public') ?>/js/apexcharts.js"></script>
<!-- lottie JavaScript -->
<script src="<?= base_url('public') ?>/js/lottie.js"></script>
<!-- Slick JavaScript -->
<script src="<?= base_url('public') ?>/js/slick.min.js"></script>
<!-- Select2 JavaScript -->
<script src="<?= base_url('public') ?>/js/select2.min.js"></script>
<!-- Owl Carousel JavaScript -->
<script src="<?= base_url('public') ?>/js/owl.carousel.min.js"></script>
<!-- Magnific Popup JavaScript -->
<script src="<?= base_url('public') ?>/js/jquery.magnific-popup.min.js"></script>
<!-- Smooth Scrollbar JavaScript -->
<script src="<?= base_url('public') ?>/js/smooth-scrollbar.js"></script>
<!-- Style Customizer -->
<script src="<?= base_url('public') ?>/js/style-customizer.js"></script>
<!-- Chart Custom JavaScript -->
<script src="<?= base_url('public') ?>/js/chart-custom.js"></script>
<!-- Custom JavaScript -->
<script src="<?= base_url('public') ?>/js/custom.js"></script>
</body>
</html>
