<?php
echo view("partial/header");
?>
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->
    <!-- MASK -->
    <script src="<?= base_url('public/jquery-mask') ?>/jquery.mask.min.js"></script>
    <!-- Wrapper Start -->
    <div class="wrapper">
        <?= view("partial/menu") ?>

        <!-- Page Content  -->
        <div id="content-page" class="content-page">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('bill') ?>">Tagihan</a></li>
                            <li class="breadcrumb-item active">Edit Bill</li>
                        </ol>
                        <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Edit Tagihan</h4>
                                </div>
                            </div>
                            <div class="iq-card-body">

                                <?php
                                $inputs = session()->getFlashdata('inputs') ?? [];
                                $errors = session()->getFlashdata('errors');
                                $success = session()->getFlashdata('success');
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
                                <?php } ?>
                                <?php
                                if (!empty($success)) {
                                    ?>
                                    <div class="alert alert-success" role="alert">
                                        <?= $success ?>
                                    </div>
                                <?php } ?>

                                <form class="form-horizontal" action="<?= base_url('bill/update') ?>"
                                      method="post">
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="hidden" name="id" id="id" value="<?= $bill['bill_id'] ?>"/>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-4 align-self-center mb-0"
                                                       for="account_name">Nama Akun</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" name="account_name"
                                                           id="account_name" value="<?= $account['account_name'] ?>"
                                                           readonly placeholder="Nama Akun">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-4 align-self-center mb-0"
                                                       for="recording_date">Tanggal Pencatatan</label>
                                                <div class="col-sm-8">
                                                    <input type="date" <?= $bill['status'] != 0 ? "readonly" : "" ?>
                                                           class="form-control" name="recording_date"
                                                           id="recording_date" value="<?= $bill['recording_date'] ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-4 align-self-center mb-0"
                                                       for="due_date">Jatuh Tempo</label>
                                                <div class="col-sm-8">
                                                    <input type="date" <?= $bill['status'] != 0 ? "readonly" : "" ?>
                                                           class="form-control" name="due_date"
                                                           id="due_date" value="<?= $bill['due_date'] ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-4 align-self-center mb-0"
                                                       for="balance_start">Saldo Awal</label>
                                                <div class="col-sm-8">
                                                    <input readonly type="text" class="form-control"
                                                           name="balance_start"
                                                           id="balance_start"
                                                           value="<?= number_format(($bill['balance_start'])) ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-4 align-self-center mb-0"
                                                       for="grand_total">Total Hutang</label>
                                                <div class="col-sm-8">
                                                    <input readonly type="text" class="form-control" name="grand_total"
                                                           id="grand_total"
                                                           value="<?= number_format(($bill['grand_total'])) ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-4 align-self-center mb-0"
                                                       for="payment">Total Payment</label>
                                                <div class="col-sm-8">
                                                    <input readonly type="text" class="form-control" name="payment"
                                                           id="payment"
                                                           value="<?= number_format(($bill['payment'])) ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-4 align-self-center mb-0"
                                                       for="balance_end">Saldo Akhir</label>
                                                <div class="col-sm-8">
                                                    <input readonly type="text" class="form-control"
                                                           name="balance_end"
                                                           id="balance_end"
                                                           value="0"/>
                                                    <span class="text-danger alert-send-saldo">Saldo akan disimpan untuk tagihan selanjutnya</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="control-label col-sm-4 align-self-center mb-0"
                                                       for="status">Status</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" name="status" id="status">
                                                        <option value="0" <?= $bill['status'] == 0 ? "selected" : "" ?>>
                                                            Open
                                                        </option>
                                                        <option value="1" <?= $bill['status'] == 1 ? "selected" : "" ?>>
                                                            Active
                                                        </option>
                                                        <option value="2" <?= $bill['status'] == 2 ? "selected" : "" ?>>
                                                            Closed
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-save">Simpan</button>&nbsp;
                                                <a href="<?= base_url('bill') ?>" class="btn iq-bg-danger">Kembali</a>
                                            </div>
                                        </div>
                                        <?php if ($bill['status'] == 1) { ?>
                                            <div class="col-6">
                                                <div class="form-group row">
                                                    <label class="control-label col-sm-4 align-self-center mb-0"
                                                           for="payment_date">Tanggal Pembayaran</label>
                                                    <div class="col-sm-8">
                                                        <input type="date" class="form-control" name="payment_date"
                                                               id="payment_date" value="<?= date('Y-m-d') ?>"/>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="control-label col-sm-4 align-self-center mb-0"
                                                           for="payment_account_id">Akun Pembayaran</label>

                                                    <div class="col-sm-8">
                                                        <select name="payment_account_id" id="payment_account_id"
                                                                class="form-control select2">
                                                            <?php
                                                            $inputs['payment_account_id'] = $inputs['payment_account_id'] ?? '';
                                                            foreach ($account_debit as $ad) {
                                                                $selected = "";
                                                                if ($ad['account_id'] == $inputs['payment_account_id']) $selected = "selected";
                                                                echo "<option " . $selected . " value='" . $ad['account_id'] . "'>" . $ad['account_name'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="control-label col-sm-4 align-self-center mb-0"
                                                           for="total_bill">Total Tagihan</label>

                                                    <div class="col-sm-8">
                                                        <input type="text" name="total_bill" id="total_bill"
                                                               class="form-control" readonly
                                                               value="<?= number_format($bill['balance_start'] + $bill['grand_total'] - $bill['payment']) ?>"
                                                        >
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="control-label col-sm-4 align-self-center mb-0"
                                                           for="payment_amount">Nominal Pembayaran</label>

                                                    <div class="col-sm-8">
                                                        <input type="text" name="payment_amount" id="payment_amount"
                                                               class="form-control money"
                                                               onchange="changePaymentAmount()"
                                                               value="<?= $inputs['payment_amount'] ?? '0' ?>"
                                                               required>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Akun</th>
                                                <th>Kategori</th>
                                                <th>Tanggal</th>
                                                <th>Keterangan</th>
                                                <th>Cicilan</th>
                                                <th>Nominal Hutang</th>
                                                <th>Nominal Bayar</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $totalDebit = 0;
                                            $totalCredit = 0;
                                            foreach ($bill_item as $no => $bi) {
                                                $linkDelete = "";
                                                if ($bill['status'] == 0) {
                                                    $linkDelete = "<a onclick='return confirmDelete()' href='" . base_url('MutationCredit/delete') . "?id=" . $bi['mutation_credit_id'] . "' data-toggle='tooltip' data-placement='top' title='Hapus Tagihan' class='btn btn-danger'><i class='fa fa-trash'></i></a>";
                                                }
                                                if ($bi['mutation_type'] == 'debit') {
                                                    $debit = $bi['mutation_nominal'];
                                                    $credit = 0;
                                                } else {
                                                    $debit = 0;
                                                    $credit = $bi['mutation_nominal'];
                                                }
                                                $totalDebit += $debit;
                                                $totalCredit += $credit;
                                                ?>
                                                <tr>
                                                    <td><?= $no + 1 ?></td>
                                                    <td><?= $bi['account_name'] ?></td>
                                                    <td><?= $bi['category_name'] ?></td>
                                                    <td><?= date('d-m-Y', strtotime($bi['mutation_date'])) ?></td>
                                                    <td><?= $bi['mutation_description'] ?></td>
                                                    <td><?= $bi['installment_number'] . " / " . $bi['installment_total'] ?></td>
                                                    <td class="text-right"><?= number_format($debit) ?></td>
                                                    <td class="text-right"><?= number_format($credit) ?></td>
                                                    <td><?= $linkDelete ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            </tbody>
                                            <tfoot class="font-weight-bold">
                                            <tr>
                                                <td colspan="6" class="text-right">TOTAL :</td>
                                                <td class="text-right">
                                                    <input type="hidden" name="total_debt_before"
                                                           id="total_debit_before"
                                                           value="<?= $totalDebit ?>"><?= number_format($totalDebit) ?>
                                                </td>
                                                <td class="text-right"><input type="hidden" name="total_credit_before"
                                                                              id="total_credit_before"
                                                                              value="<?= $totalCredit ?>"><?= number_format($totalCredit) ?>
                                                </td>
                                                <td></td>
                                            </tr>
                                            </tfoot>
                                        </table>
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
    <script type="text/javascript">
        $("document").ready(function () {
            $(".select2").select2();
            changePaymentAmount();
        });
        $('.money').mask('000,000,000,000,000', {reverse: true});

        function changeParentId() {
            var textParent = $("#category_parent_id option:selected").text();
            $("#category_parent_name").val(textParent);
        }

        function confirmDelete() {
            if (confirm('Yakin menghapus item tagihan?')) {
                return true;
            } else {
                return false;
            }
        }

        function changePaymentAmount() {
            var paymentAmount = $("#payment_amount").val();
            paymentAmount = toNumber(paymentAmount);
            updateTotalPayment(paymentAmount);
        }

        function updateTotalPayment(paymentAmount) {
            var totalCreditBefore = $("#total_credit_before").val();
            var hitung = paymentAmount + toNumber(totalCreditBefore);
            $("#payment").val(toRupiah(hitung));
            updateBalance();
        }

        function updateBalance() {
            var startBalance = $("#balance_start").val();
            var tagihan = $("#grand_total").val();
            var payment = $("#payment").val();
            var endBalance = toNumber(startBalance) + toNumber(tagihan) - toNumber(payment);
            /* jika endbalance == 0 status to close
               jika endbalance > 0 send to tagihan selanjutnnya
               jika endbalance < 0 tombol save tidak bisa simpan
             */
            if (endBalance < 0) {
                $(".btn-save").hide();
                $(".alert-send-saldo").hide();
            } else if (endBalance > 0) {
                $(".btn-save").show();
                $(".alert-send-saldo").show();
            } else {
                $(".alert-send-saldo").hide();
                $(".btn-save").show();
            }
            $("#balance_end").val(toRupiah(endBalance));
        }

        function toNumber(value) {
            return parseInt(value.replace(/,/g, '')) || 0;
        }

        function toRupiah(value) {
            return value.toLocaleString('en-US');
        }
    </script>
<?php
echo view("partial/footer");
?>