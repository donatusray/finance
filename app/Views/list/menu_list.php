<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 18/02/2024
 * Time: 01:30
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
                                    <h4 class="card-title">Daftar Menu</h4>
                                </div>
                            </div>
                            <div class="iq-card-body">
                                <a href="<?= base_url('menus/add') ?>" class="btn btn-success" data-toggle="tooltip"
                                   data-placement="top" title="Tambah Menu"><i
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
                                            <th>Cabang</th>
                                            <th>Link</th>
                                            <th>Icon</th>
                                            <th>Keterangan</th>
                                            <th>Aktif</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($list_menu as $no => $lm) {
                                            $linkEdit = "<a href='" . base_url('menus/edit') . "?id=" . $lm['menu_id'] . "' data-toggle='tooltip'
                                   data-placement='top' title='Ubah Menu' class='btn btn-primary'><i class='fa fa-edit'></i></a>";
                                            $linkDelete = "<a onclick='return confirmDelete()' href='" . base_url('menus/delete') . "?id=" . $lm['menu_id'] . "' data-toggle='tooltip' data-placement='top' title='Hapus Menu' class='btn btn-danger'><i class='fa fa-trash'></i></a>";
                                            ?>
                                            <tr>
                                                <td><?= $no + 1 ?></td>
                                                <td><?= $lm['menu_name'] ?></td>
                                                <td><?= $lm['parent_name'] ?></td>
                                                <td><?= $lm['menu_link'] ?></td>
                                                <td><?= $lm['menu_icon'] ?></td>
                                                <td><?= $lm['menu_description'] ?></td>
                                                <td><?= $lm['menu_isactive'] ?></td>
                                                <td><?= $linkEdit . " " . $linkDelete ?></td>
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
