<?php
    if (!isset($_SESSION))
        session_start();

    if (!(isset($_SESSION['signedIn']) && $_SESSION['signedIn'])) {
        header("location:./index.php");
    }
?>

<!DOCTYPE html>
<html>
<head>
    <?php
        include "header.php";
    ?>
    <title>Purchase History</title>
    <link href="./css/ui.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="./css/admin.css"/>

    <link rel="stylesheet" type="text/css" href="./libs/datatables/datatables.min.css"/>
    <script type="text/javascript" src="./libs/datatables/datatables.min.js"></script>

    <script type="text/javascript" src="./libs/daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="./libs/daterangepicker/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="./libs/daterangepicker/daterangepicker.css"/>
</head>
<body id="page-top">
<?php
    include "navbar.php";
?>
<div id="wrapper">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <div class="sidebar-brand d-flex align-items-center justify-content-center">
            <div class="sidebar-brand-icon">
                <i class="fas fa-user"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Personal Page</div>
        </div>
        <hr class="sidebar-divider my-0">
        <div class="sidebar-heading">
            Management
        </div>
        <li class="nav-item">
            <a class="nav-link" href="./wish-list.php">
                <i class="fas fa-heart"></i>
                <span> Wish List</span>
            </a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="./invoices.php">
                <i class="fas fa-file-invoice-dollar"></i>
                <span> Purchase History</span>
            </a>
        </li>
        <hr class="sidebar-divider d-none d-md-block">
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>

    <div id="content-wrapper" class="d-flex flex-column" style="padding-top: 15px">
        <div class="container" id="content">
            <h3>Purchase History</h3>
            <div class="row">
                <div class="input-group mb-3 col-md-6">
                    <input type="text" id="date-range-picker" class="form-control font-responsive"
                           placeholder="Date Range" style="text-align: center;">
                    <div class="input-group-append">
                        <button class="btn btn-primary font-responsive" type="button" style="width: 100px;"
                                id="search-invoice-button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-outline-primary font-responsive" type="button" style="float: right;"
                            id="invoice-refresh-button">
                        <i class="fas fa-sync-alt"></i>
                        <span>REFRESH</span>
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover" id="invoice-table" width="100%" cellspacing="0">
                    <thead class="table-header">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Total</th>
                        <th scope="col">Created Date</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="invoice-modal" tabindex="-1" role="dialog"
             aria-labelledby="employeeModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-invoices" style="max-width: 40%" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title modal-title-font">Invoice Detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body table-fixed-header">
                        <table class="table table-hover" id="invoice-detail-table">
                            <thead class="table-header">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary font-responsive"
                                data-dismiss="modal">
                            <i class="fas fa-ban"></i>
                            <span>Close</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <?php
            include "footer.php";
        ?>
    </div>

</div>
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<script type="text/javascript" src="./js/customer/invoices.js"></script>
</body>
</html>