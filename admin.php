<?php
    if (!isset($_SESSION))
        session_start();

    if (!(isset($_SESSION['signedIn']) && $_SESSION['signedIn'] && $_SESSION['isAdmin'])) {
        header("location:./index.php");
    }
?>

<!DOCTYPE html>
<html>

<head>
    <?php
        include "header.php";
    ?>
    <link rel="stylesheet" href="./css/admin.css"/>

    <link rel="stylesheet" type="text/css" href="./libs/datatables/datatables.min.css"/>
    <script type="text/javascript" src="./libs/datatables/datatables.min.js"></script>

    <link rel="stylesheet" type="text/css" href="./libs/chartjs/Chart.min.css"/>
    <script type="text/javascript" src="./libs/chartjs/Chart.bundle.min.js"></script>

    <script type="text/javascript" src="./libs/daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="./libs/daterangepicker/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="./libs/daterangepicker/daterangepicker.css"/>

</head>

<body id="page-top">

<?php
    include "navbar.php";
?>

<div id="wrapper" class="admin-content">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="side-bar">
        <div class="sidebar-brand d-flex align-items-center justify-content-center">
            <div class="sidebar-brand-icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Admin</div>
        </div>
        <hr class="sidebar-divider my-0">
        <li class="nav-item active">
            <a class="nav-link" href="javascript: loadDashboardPage()">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Management
        </div>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#tables-link"
               aria-expanded="true" aria-controls="tables-link">
                <i class="fas fa-fw fa-table"></i>
                <span>Data</span>
            </a>
            <div id="tables-link" class="collapse" aria-labelledby="headingTwo" data-parent="#side-bar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Tables</h6>
                    <a class="collapse-item" href="javascript: loadEmployeesPage()">Employees</a>
                    <a class="collapse-item" href="javascript: loadProductsPage()">Products</a>
                    <a class="collapse-item" href="javascript: loadManufacturersPage()">Manufacturer</a>
                    <a class="collapse-item" href="javascript: loadCustomersPage()">Customers</a>
                    <a class="collapse-item" href="javascript: loadInvoicesPage()">Invoices</a>
                </div>
            </div>
        </li>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Analysis
        </div>
        <li class="nav-item">
            <a class="nav-link" href="javascript: loadRevenuePage()">
                <i class="fas fa-coins"></i>
                <span>Revenue</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="javascript: loadTopSellersPage()">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Top Sellers</span></a>
        </li>
        <hr class="sidebar-divider d-none d-md-block">
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>

    <div id="content-wrapper" class="d-flex flex-column" style="padding-top: 15px">
        <div id="content">

        </div>
        <?php
            include "footer.php";
        ?>
    </div>

</div>

<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<script type="text/javascript" src="./js/admin/admin.js"></script>

</body>
</html>
