<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 22/04/2024
 * Time: 23:39
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
                                    <h4 class="card-title">Daftar Mutasi</h4>
                                </div>
                            </div>
                            <div class="iq-card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="get_from">Tanggal Dari</label>
                                            <input type="date" name="get_from" id="get_from"
                                                   value="<?= date('Y-m-d', strtotime($get_from)) ?>"
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="get_to">Tanggal Sampai</label>
                                            <input type="date" name="get_to" id="get_to"
                                                   value="<?= date('Y-m-d', strtotime($get_to)) ?>"
                                                   class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="get_account">Akun</label>
                                            <select name="get_account" id="get_account" class="form-control">
                                                <option value="">Pilih Akun</option>
                                                <?php
                                                foreach ($accounts as $account) {
                                                    $selected = "";
                                                    if ($account['account_id'] == $get_account) {
                                                        $selected = "selected";
                                                    }
                                                    echo "<option " . $selected . " value='" . $account['account_id'] . "'>" . $account['account_name'] . " (" . $account['account_active'] . ")</option>";
                                                }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input type="button" name="btnShowData" onclick="showData()" class="btn btn-dark"
                                       value="Tampilkan Data">
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
                                    <table id="datatable" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Akun Debet</th>
                                            <th>Akun Kredit</th>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                            <th>Debet</th>
                                            <th>Credit</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $totalNominalDebet = 0;
                                        $totalNominalCredit = 0;
                                        foreach ($mutation as $no => $mut) {
                                            $nominalDebet = 0;
                                            $nominalCredit = 0;
                                            if ($get_account != '') {
                                                if ($get_account == $mut['account_id_income']) {
                                                    $nominalDebet = $mut['mutation_amount'];
                                                    $mut['account_credit'] = "";
                                                }
                                                if ($get_account == $mut['account_id_expense']) {
                                                    $nominalCredit = $mut['mutation_amount'];
                                                    $mut['account_debet'] = "";
                                                }
                                            } else {
                                                if ($mut['account_debet'] != '') {
                                                    $nominalDebet = $mut['mutation_amount'];
                                                }
                                                if ($mut['account_credit'] != '') {
                                                    $nominalCredit = $mut['mutation_amount'];
                                                }
                                            }
                                            $totalNominalDebet += $nominalDebet;
                                            $totalNominalCredit += $nominalCredit;
                                            echo "<tr>";
                                            echo "<td>" . ($no + 1) . "</td>";
                                            echo "<td>" . $mut['account_debet'] . "</td>";
                                            echo "<td>" . $mut['account_credit'] . "</td>";
                                            echo "<td>" . date('d-m-Y', strtotime($mut['mutation_date'])) . "</td>";
                                            echo "<td>" . $mut['mutation_text'] . "</td>";
                                            echo "<td class='text-right'>" . number_format($nominalDebet) . "</td>";
                                            echo "<td class='text-right'>" . number_format($nominalCredit) . "</td>";
                                            echo "<td></td>";
                                            echo "</tr>";
                                        }
                                        $saldo = $totalNominalDebet - $totalNominalCredit;

                                        ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="5">Total</td>
                                            <td class='text-right'><?= number_format($totalNominalDebet) ?></td>
                                            <td class='text-right'><?= number_format($totalNominalCredit) ?></td>
                                            <td class="text-right"><?= ($saldo > 0) ? "<span class='text-success'>" . number_format($saldo) . "</span>" : "<span class='text-danger'>" . number_format($saldo) . "</span>"; ?></td>
                                        </tr>
                                        </tfoot>
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
//        $(function () {
//            $("#example2").DataTable();
//        });
        function showData() {
            var awal = $("#get_from").val();
            var akhir = $("#get_to").val();
            var account = $("#get_account").val();
            window.location = "<?php echo base_url('mutation')?>?from=" + awal + "&to=" + akhir + "&account=" + account;
        }
    </script>

<?php
echo view("partial/footer");