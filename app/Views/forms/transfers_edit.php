<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 11/04/2024
 * Time: 23:11
 */
echo view("partial/header");
?>
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- MASK -->
    <script src="<?= base_url('public/jquery-mask') ?>/jquery.mask.min.js"></script>

    <div class="wrapper">
        <?= view("partial/menu") ?>

        <!-- Page Content  -->
        <div id="content-page" class="content-page">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('transfers') ?>">Transfers</a></li>
                            <li class="breadcrumb-item active">Edit Transfer</li>
                        </ol>
                        <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Edit Transfer</h4>
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
                                <?php } ?>

                                <form class="form-horizontal" action="<?= base_url('transfers/update') ?>"
                                      method="post">
                                    <input type="hidden" name="id" id="id" value="<?= $inputs['id'] ?>"/>

                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="transfer_date">Tanggal Transfer <span
                                                class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <input type="date" name="transfer_date" id="transfer_date"
                                                   value="<?= $inputs['transfer_date'] ?>"
                                                   onchange="createDescription()"
                                                   class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="account_credit">Sumber Transfer<span
                                                class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <select required name="account_credit" id="account_credit"
                                                    onchange="createDescription()"
                                                    class="form-control">
                                                <?php
                                                echo "<option value='" . $ae['account_id'] . "' selected>" . $ae['account_name'] . "</option>";
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="account_debet">Transfer Tujuan <span
                                                class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <select required name="account_debet" id="account_debet"
                                                    class="form-control" onchange="createDescription()">
                                                <?php
                                                echo "<option selected value='" . $ai['account_id'] . "'>" . $ai['account_name'] . "</option>";
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="nominal">Nominal <span class="text-danger">*</span></label>

                                        <div class="col-sm-10">
                                            <input type="text" name="nominal" id="nominal"
                                                   class="form-control money" value="<?= $inputs['nominal'] ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="transfer_description">Keterangan</label>

                                        <div class="col-sm-10">
                                            <textarea rows="2" name="transfer_description" id="transfer_description"
                                                      placeholder="Keterangan"
                                                      class="form-control"><?= $inputs['transfer_description'] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="<?= base_url('transfers') ?>" class="btn iq-bg-danger">Kembali</a>
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
        $('.money').mask('000,000,000,000,000', {reverse: true});

        function createDescription() {
            var transferDate = $("#transfer_date").val();
            var accountDebetId = $("#account_debet").val();
            var accountCreditId = $("#account_credit").val();
            var textAccountDebetId = $("#account_debet option:selected").text();
            if (accountDebetId == "") {
                textAccountDebetId = "";
            }
            var textAccountCreditId = $("#account_credit option:selected").text();
            if (accountCreditId == "") {
                textAccountCreditId = "";
            }
            var text = "Transfer " + textAccountCreditId + " ke " + textAccountDebetId + " " + transferDate;
            $("#transfer_description").val(text);
        }
    </script>
<?php
echo view("partial/footer");
?>