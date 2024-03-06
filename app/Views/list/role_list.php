<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 03/03/2024
 * Time: 00:03
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
                                    <h4 class="card-title">Daftar Role</h4>
                                </div>
                            </div>
                            <div class="iq-card-body">
                                <a href="<?= base_url('roles/add') ?>" class="btn btn-success" data-toggle="tooltip"
                                   data-placement="top" title="Tambah Role"><i
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
                                            <th>Nama</th>
                                            <th>Keterangan</th>
                                            <th>Aktif</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($list_role as $no => $lr) {
                                            $linkEdit = "<a href='" . base_url('roles/edit') . "?id=" . $lr['role_id'] . "' data-toggle='tooltip'
                                   data-placement='top' title='Ubah Role' class='btn btn-primary'><i class='fa fa-edit'></i></a>";
                                            $linkEditMenu = "<a href='" . base_url('roles/rolemenu') . "?role=" . $lr['role_id'] . "' data-toggle='tooltip'
                                   data-placement='top' title='Setting Role Menu' class='btn btn-warning'><i class='fa fa-gear'></i></a>";
                                            $linkDelete = "<a onclick='return confirmDelete()' href='" . base_url('roles/delete') . "?id=" . $lr['role_id'] . "' data-toggle='tooltip' data-placement='top' title='Hapus Role' class='btn btn-danger'><i class='fa fa-trash'></i></a>";
                                            $iconActive = "<span class='badge badge-success'><i class='las la-check'></i></span>";
                                            if ($lr['isactive'] == 'N') {
                                                $iconActive = "<span class='badge badge-danger'><i class='las la-times'></i></span>";
                                            }

                                            ?>
                                            <tr>
                                                <td><?= $no + 1 ?></td>
                                                <td><?= $lr['role_name'] ?></td>
                                                <td><?= $lr['description'] ?></td>
                                                <td><?= $iconActive ?></td>
                                                <td><?= $linkEditMenu . " " . $linkEdit . " " . $linkDelete ?></td>
                                            </tr>
                                        <?php } ?>
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
        $(function () {
            $("#example2").DataTable();
        });

        function confirmDelete() {
            if (confirm('Yakin menghapus menu?')) {
                return true;
            } else {
                return false;
            }
        }
    </script>
<?php
echo view("partial/footer");
