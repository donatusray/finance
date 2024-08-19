<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 13/03/2024
 * Time: 17:24
 */
echo view("partial/header");
?>
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>

    <div class="wrapper">
        <?= view("partial/menu") ?>

        <!-- Page Content  -->
        <div id="content-page" class="content-page">
            <div class="card iq-mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="filter_time">Filter Waktu</label>
                                <select name="filter_time" id="filter_time" onchange="changeTime()"
                                        class="form-control">
                                    <?php
                                    foreach ($filter_waktu as $fw) {
                                        $selected = "";
                                        if ($fw == $get_waktu) {
                                            $selected = "selected";
                                        }
                                        echo "<option value='" . $fw . "' " . $selected . ">" . ucfirst($fw) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                            <div class="iq-card-body iq-box-relative">
                                <div class="iq-box-absolute icon iq-icon-box rounded-circle iq-bg-primary">
                                    <i class="ri-focus-2-line"></i>
                                </div>
                                <p class="text-secondary">Total Pemasukan</p>

                                <div class="d-flex align-items-center justify-content-between">
                                    <div id="iq-chart-box1"></div>
                                    <h4><b><?= $show_income ?></b></h4>
                                    <span class="text-primary">
                                        <b> <?= $percent_income ?>%
                                            <?php
                                            if ($percent_income > 0) {
                                                echo '<i class="ri-arrow-up-fill"></i>';
                                            } else {
                                                echo '<i class="ri-arrow-down-fill"></i>';
                                            }
                                            ?>
                                        </b>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3">
                        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                            <div class="iq-card-body iq-box-relative">
                                <div class="iq-box-absolute icon iq-icon-box rounded-circle iq-bg-danger">
                                    <i class="ri-pantone-line"></i>
                                </div>
                                <p class="text-secondary">Total Pengeluaran</p>

                                <div class="d-flex align-items-center justify-content-between">
                                    <div id="iq-chart-box2"></div>
                                    <h4><b><?= $show_expense ?></b></h4>

                                    <span class="text-danger">
                                        <b> <?= $percent_expense ?>%
                                            <?php
                                            if ($percent_expense > 0) {
                                                echo '<i class="ri-arrow-up-fill"></i>';
                                            } else {
                                                echo '<i class="ri-arrow-down-fill"></i>';
                                            }
                                            ?>
                                        </b>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Wrapper END -->
    <script type="text/javascript">

        if ($('#iq-chart-box1').length > 0) {
            var options = {
                series: [{
                    name: "Pemasukan",
                    data: [<?=$array_value_expense?>]
                }],
                colors: ["#1e3d73"],
                chart: {
                    height: 50,
                    width: 100,
                    type: 'line',
                    sparkline: {
                        enabled: true,
                    },
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: [<?=$array_header_income?>],
                }
            };

            var chart = new ApexCharts(document.querySelector("#iq-chart-box1"), options);
            chart.render();
        }

        if ($('#iq-chart-box2').length > 0) {
            var options = {
                series: [{
                    name: "Pengeluaran",
                    data: [<?=$array_value_expense?>]
                }],
                colors: ["#fe517e"],
                chart: {
                    height: 50,
                    width: 100,
                    type: 'line',
                    sparkline: {
                        enabled: true,
                    },
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: [<?=$array_header_expense?>],
                }
            };

            var chart = new ApexCharts(document.querySelector("#iq-chart-box2"), options);
            chart.render();
        }

        function changeTime() {
            var selectTime = $("#filter_time").val();
            redirectDashboard(selectTime);
        }

        function redirectDashboard(selectTime) {
            var url = "<?=base_url('home')?>";
            url += "?waktu=" + selectTime;
            window.location = url;
        }
    </script>
<?php
echo view("partial/footer");