<?php
echo view("partial/header");
?>
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>

    <link rel="stylesheet"
          href="<?php echo base_url('public'); ?>/datatables-bs4/css/dataTables.bootstrap4.css">
    <script src="<?php echo base_url('public'); ?>/datatables/jquery.dataTables.js"></script>
    <script src="<?php echo base_url('public'); ?>/datatables-bs4/js/dataTables.bootstrap4.js"></script>

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
                                    <h4 class="card-title">Daftar Tagihan</h4>
                                </div>
                            </div>
                            <div class="iq-card-body">
                                <div class="card iq-mb-3">
                                    <div class="card-body">
                                        <!--                                    <div class="row">-->
                                        <!--                                        <div class="col-md-3">-->
                                        <!--                                            <div class="form-group">-->
                                        <!--                                                <label for="filter_from">Tanggal Pemasukan Dari</label>-->
                                        <!--                                                <input type="date" name="filter_from" id="filter_from"-->
                                        <!--                                                       value="-->
                                        <?php //= $get_from ?><!--" class="form-control">-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->
                                        <!--                                        <div class="col-md-3">-->
                                        <!--                                            <div class="form-group">-->
                                        <!--                                                <label for="filter_to">Tanggal Pemasukan Sampai</label>-->
                                        <!--                                                <input type="date" name="filter_to" id="filter_to"-->
                                        <!--                                                       value="-->
                                        <?php //= $get_to ?><!--" class="form-control">-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->
                                        <!--                                        <div class="col-md-3">-->
                                        <!--                                            <div class="form-group">-->
                                        <!--                                                <label for="filter_category">Kategori Pemasukan</label>-->
                                        <!--                                                <select name="filter_category" id="filter_category"-->
                                        <!--                                                        class="form-control">-->
                                        <!--                                                    <option value="">All</option>-->
                                        <!--                                                    --><?php
                                        //                                                    foreach ($categories as $cat) {
                                        //                                                        $selected = "";
                                        //                                                        if ($cat['category_id'] == $get_category) {
                                        //                                                            $selected = "selected";
                                        //                                                        }
                                        //                                                        echo "<option value='" . $cat['category_id'] . "' " . $selected . ">" . $cat['category_name'] . "</option>";
                                        //                                                    }
                                        //                                                    ?>
                                        <!--                                                </select>-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->
                                        <!--                                        <div class="col-md-3">-->
                                        <!--                                            <div class="form-group">-->
                                        <!--                                                <label for="filter_account">Akun Pemasukan</label>-->
                                        <!--                                                <select name="filter_account" id="filter_account"-->
                                        <!--                                                        class="form-control">-->
                                        <!--                                                    <option value="">All</option>-->
                                        <!--                                                    --><?php
                                        //                                                    foreach ($accounts as $account) {
                                        //                                                        $selected = "";
                                        //                                                        if ($account['account_id'] == $get_account) {
                                        //                                                            $selected = "selected";
                                        //                                                        }
                                        //                                                        echo "<option value='" . $account['account_id'] . "' " . $selected . ">" . $account['account_name'] . "</option>";
                                        //                                                    }
                                        //                                                    ?>
                                        <!--                                                </select>-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->
                                        <!--                                        <div class="col-md-3">-->
                                        <!--                                            <button type="button" name="btn" class="btn btn-primary"-->
                                        <!--                                                    onclick="search()"><i class="las la-search"></i> Cari Data-->
                                        <!--                                            </button>-->
                                        <!--                                        </div>-->
                                        <!--                                    </div>-->
                                    </div>
                                </div>
                                <hr>

                                <a href="<?= base_url('income/add') ?>" class="btn btn-success"
                                   data-toggle="tooltip"
                                   data-placement="top" title="Tambah Pemasukan"><i
                                            class="fa fa-plus"></i></a>
                                <br><br>

                                <?php
                                if (!empty(session()->getFlashdata('success'))) {
                                    echo '<div class="alert alert-success">';
                                    echo session()->getFlashdata('success');
                                    echo '</div>';
                                }
                                if (!empty(session()->getFlashdata('info'))) {
                                    echo '<div class="alert alert-info">';
                                    echo session()->getFlashdata('info');
                                    echo '</div>';
                                }
                                if (!empty(session()->getFlashdata('warning'))) {
                                    echo '<div class="alert alert-warning">';
                                    echo session()->getFlashdata('warning');
                                    echo '</div>';
                                }
                                ?>

                                <div class="table-responsive">
                                    <table id="example2" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Akun</th>
                                            <th>Tanggal Pencatatan</th>
                                            <th>Jatuh Tempo</th>
                                            <th>Total</th>
                                            <th>Pembayaran</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($bills as $no => $bill) {
                                            $linkEdit = "<a href='" . base_url('bill/edit') . "?id=" . $bill['bill_id'] . "' data-toggle='tooltip'
                                   data-placement='top' title='Ubah Tagihan' class='btn btn-primary'><i class='fa fa-edit'></i></a>";
                                            echo "<tr>";
                                            echo "<td>" . ($no + 1) . "</td>";
                                            echo "<td>" . $bill['account_name'] . "</td>";
                                            echo "<td>" . date('d-m-Y', strtotime($bill['recording_date'])) . "</td>";
                                            echo "<td>" . date('d-m-Y', strtotime($bill['due_date'])) . "</td>";
                                            echo "<td class='text-right'>" . number_format($bill['grand_total'], 0, '.', ',') . "</td>";
                                            echo "<td class='text-right'>" . number_format($bill['payment'], 0, '.', ',') . "</td>";
                                            echo "<td>" . $linkEdit . "</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
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
        $(function () {
            $("#example2").DataTable();
        });

        function search() {
            var from = $("#filter_from").val();
            var to = $("#filter_to").val();
            var account = $("#filter_account").val();
            var category = $("#filter_category").val();
            window.location = "<?=base_url('income')?>?from=" + from + "&to=" + to + "&account=" + account + "&category=" + category;
        }

        function confirmDelete() {
            if (confirm('Yakin menghapus pemasukan?')) {
                return true;
            } else {
                return false;
            }
        }
    </script>

<?php
echo view("partial/footer");