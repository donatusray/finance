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
                                <h4 class="card-title">Bootstrap Datatables</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <p>Images in Bootstrap are made responsive with <code>.img-fluid</code>. <code>max-width:
                                    100%;</code> and <code>height:
                                    auto;</code> are applied to the image so that it scales with the parent element.
                            </p>

                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Age</th>
                                        <th>Start date</th>
                                        <th>Salary</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>2011/04/25</td>
                                        <td>$320,800</td>
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



<?php
echo view("partial/footer");
