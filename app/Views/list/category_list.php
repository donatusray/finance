<?php
/**
 * Created by PhpStorm.
 * User: IT PETUALANG
 * Date: 09/02/2024
 * Time: 23:23
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
                                    <h4 class="card-title">Daftar Kategori</h4>
                                </div>
                            </div>
                            <div class="iq-card-body">
                                <a href="<?= base_url('categories/add') ?>" class="btn btn-success"
                                   data-toggle="tooltip"
                                   data-placement="top" title="Tambah Kategori"><i
                                        class="fa fa-plus"></i></a>
                                <button type="button" class="btn btn-primary" data-target="#filterCategoryModal"
                                        data-toggle="modal" title="Filter Kategori"><i
                                        class="fa fa-search"></i></button>
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
                                            <th>Kategori</th>
                                            <th>Parent</th>
                                            <th>Tipe</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($categories as $no => $category) {
                                            $linkEdit = "<a href='" . base_url('categories/edit') . "?id=" . $category['category_id'] . "' data-toggle='tooltip'
                                   data-placement='top' title='Ubah Kategori' class='btn btn-primary'><i class='fa fa-edit'></i></a>";
                                            $linkDelete = "<a onclick='return confirmDelete()' href='" . base_url('categories/delete') . "?id=" . $category['category_id'] . "' data-toggle='tooltip' data-placement='top' title='Hapus Kategori' class='btn btn-danger'><i class='fa fa-trash'></i></a>";
                                            echo "<tr>";
                                            echo "<td>" . ($no + 1) . "</td>";
                                            echo "<td>" . $category['category_name'] . "</td>";
                                            echo "<td>" . $category['category_parent_name'] . "</td>";
                                            echo "<td>" . $category['category_type'] . "</td>";
                                            echo "<td>" . $category['category_description'] . "</td>";
                                            echo "<td>" . $linkEdit . " " . $linkDelete . "</td>";
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
    <div class="modal fade" id="filterCategoryModal" tabindex="-1" role="dialog" aria-labelledby="filterCategoryModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Filter Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="control-label col-sm-4 align-self-center mb-0"
                               for="category_parent_id">Induk Kategori</label>

                        <div class="col-sm-8">
                            <select name="category_parent_id"
                                    id="category_parent_id" class="form-control">
                                <option value="">--Pilih Kategori Induk--</option>
                                <?php
                                foreach ($parents as $par) {
                                    $selected = "";
                                    if ($par['category_id'] == $_GET['parents']) {
                                        $selected = "selected";
                                    }
                                    echo "<option " . $selected . " value='" . $par['category_id'] . "'>" . $par['category_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <br>

                    <div class="form-group row">
                        <label class="control-label col-sm-4 align-self-center mb-0"
                               for="category_type">Tipe <span class="text-danger">*</span></label>

                        <div class="col-sm-8">
                            <select name="category_type" id="category_type" class="form-control">
                                <option value="">--Pilih Account--</option>
                                <option <?= ($_GET['tipe'] == "INCOME") ? "selected" : ""; ?> value="INCOME">INCOME
                                </option>
                                <option <?= ($_GET['tipe'] == "EXPENSE") ? "selected" : ""; ?> value="EXPENSE">EXPENSE
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="redirectSearch()" class="btn btn-primary">Cari Data</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Wrapper END -->
    <script type="text/javascript">
        $(function () {
            $("#datatable").DataTable();
        });

        function confirmDelete() {
            if (confirm('Yakin menghapus akun?')) {
                return true;
            } else {
                return false;
            }
        }

        function redirectSearch() {
            var tipe = $("#category_type").val();
            var parents = $("#category_parent_id").val();
            window.location = "<?php echo base_url('categories')?>?tipe=" + tipe + "&parents=" + parents;
        }
        $("document").ready(function () {
            $(".select2").select2();
        });
    </script>

<?php
echo view("partial/footer");
