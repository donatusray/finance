<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 10/04/2024
 * Time: 22:50
 */
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
                                    <h4 class="card-title">Daftar Transfers</h4>
                                </div>
                            </div>
                            <div class="card iq-mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="filter_from">Tanggal Transfer Dari</label>
                                                <input type="date" name="filter_from" id="filter_from"
                                                       value="<?= $get_from ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="filter_to">Tanggal Transfer Sampai</label>
                                                <input type="date" name="filter_to" id="filter_to"
                                                       value="<?= $get_to ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="filter_account_from">Akun Sumber</label>
                                                <select name="filter_account_credit" id="filter_account_credit"
                                                        class="form-control">
                                                    <option value="">All</option>
                                                    <?php
                                                    foreach ($account_expense as $ae) {
                                                        $selected = "";
                                                        if ($ae['account_id'] == $get_credit) {
                                                            $selected = "selected";
                                                        }
                                                        echo "<option value='" . $ae['account_id'] . "' " . $selected . ">" . $ae['account_name'] . "</option>";
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="filter_account">Akun Tujuan</label>
                                                <select name="filter_account_debit" id="filter_account_debit"
                                                        class="form-control">
                                                    <option value="">All</option>
                                                    <?php
                                                    foreach ($account_income as $ai) {
                                                        $selected = "";
                                                        if ($ai['account_id'] == $get_debit) {
                                                            $selected = "selected";
                                                        }
                                                        echo "<option value='" . $ai['account_id'] . "' " . $selected . ">" . $ai['account_name'] . "</option>";
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" name="btn" class="btn btn-primary"
                                                    onclick="search()"><i class="las la-search"></i> Cari Data
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="iq-card-body">
                                <a href="<?= base_url('transfers/add') ?>" class="btn btn-success"
                                   data-toggle="tooltip"
                                   data-placement="top" title="Tambah Transfer"><i
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
                                            <th>Tanggal</th>
                                            <th>Sumber</th>
                                            <th>Tujuan</th>
                                            <th>Nominal</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($transfers as $no => $transfer) {
                                            $linkCopy = "<a href='" . base_url('transfers/copy') . "?id=" . $transfer['id'] . "' data-toggle='tooltip'
                                   data-placement='top' title='Copy Transfer' class='btn btn-warning'><i class='fa fa-copy'></i></a>";
                                            $linkEdit = "<a href='" . base_url('transfers/edit') . "?id=" . $transfer['id'] . "' data-toggle='tooltip'
                                   data-placement='top' title='Ubah Transfer' class='btn btn-primary'><i class='fa fa-edit'></i></a>";
                                            $linkDelete = "<a onclick='return confirmDelete()' href='" . base_url('transfers/delete') . "?id=" . $transfer['id'] . "' data-toggle='tooltip' data-placement='top' title='Hapus Transfer' class='btn btn-danger'><i class='fa fa-trash'></i></a>";
                                            echo "<tr>";
                                            echo "<td>" . ($no + 1) . "</td>";
                                            echo "<td>" . date('d-m-Y', strtotime($transfer['transfer_date'])) . "</td>";
                                            echo "<td>" . $transfer['credit_name'] . "</td>";
                                            echo "<td>" . $transfer['debet_name'] . "</td>";
                                            echo "<td class='text-right'>" . number_format($transfer['nominal'], 0, '.', ',') . "</td>";
                                            echo "<td>" . $linkCopy . " " . $linkEdit . " " . $linkDelete . "</td>";
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
            var accountDebit = $("#filter_account_debit").val();
            var accountCredit = $("#filter_account_credit").val();
            window.location = "<?=base_url('transfers')?>?from=" + from + "&to=" + to + "&debit=" + accountDebit + "&credit=" + accountCredit;
        }

        function confirmDelete() {
            if (confirm('Yakin menghapus transfer?')) {
                return true;
            } else {
                return false;
            }
        }
    </script>

<?php
echo view("partial/footer");