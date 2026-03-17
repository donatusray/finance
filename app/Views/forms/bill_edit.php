<?php
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
                                    <input type="hidden" name="id" id="id" value="<?= $bill['bill_id'] ?>"/>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="account_name">Nama Akun</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="account_name"
                                                   id="account_name" value="<?= $account['account_name'] ?>"
                                                   readonly placeholder="Nama Akun">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="recording_date">Tanggal Pencatatan</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" name="recording_date"
                                                   id="recording_date" value="<?= $bill['recording_date'] ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="due_date">Jatuh Tempo</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" name="due_date"
                                                   id="due_date" value="<?= $bill['due_date'] ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="grand_total">Total Tagihan</label>
                                        <div class="col-sm-10">
                                            <input readonly type="text" class="form-control" name="grand_total"
                                                   id="grand_total"
                                                   value="<?= number_format(($bill['grand_total'])) ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="grand_total">Total Payment</label>
                                        <div class="col-sm-10">
                                            <input readonly type="text" class="form-control" name="grand_total"
                                                   id="grand_total" value="<?= number_format(($bill['payment'])) ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2 align-self-center mb-0"
                                               for="status">Status</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="status" id="status">
                                                <option value="0">Open</option>
                                                <option value="1">Active</option>
                                                <option value="2">Closed</option>
                                            </select>
                                        </div>
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
                                                <th>Nominal</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($bill_item as $no => $bi) {
                                                $linkDelete = "";
                                                if ($bi['status'] == 0) {
                                                    $linkDelete = "<a onclick='return confirmDelete()' href='" . base_url('MutationCredit/delete') . "?id=" . $bi['mutation_credit_id'] . "' data-toggle='tooltip' data-placement='top' title='Hapus Tagihan' class='btn btn-danger'><i class='fa fa-trash'></i></a>";
                                                }
                                                ?>
                                                <tr>
                                                    <td><?= $no + 1 ?></td>
                                                    <td><?= $bi['account_name'] ?></td>
                                                    <td><?= $bi['category_name'] ?></td>
                                                    <td><?= date('d-m-Y', strtotime($bi['mutation_date'])) ?></td>
                                                    <td><?= $bi['mutation_description'] ?></td>
                                                    <td><?= $bi['installment_number'] . " / " . $bi['installment_total'] ?></td>
                                                    <td class="text-right"><?= number_format($bi['mutation_nominal']) ?></td>
                                                    <td><?= $linkDelete ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="<?= base_url('bill') ?>" class="btn iq-bg-danger">Kembali</a>
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
    </script>
<?php
echo view("partial/footer");
?>