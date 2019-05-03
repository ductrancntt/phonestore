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
    <title>Admin</title>
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
<!--        <hr class="sidebar-divider my-0">-->
<!--        <li class="nav-item active">-->
<!--            <a class="nav-link" href="javascript: loadDashboardPage()">-->
<!--                <i class="fas fa-fw fa-tachometer-alt"></i>-->
<!--                <span>Dashboard</span></a>-->
<!--        </li>-->
<!--        <hr class="sidebar-divider">-->
        <div class="sidebar-heading">
            Management
        </div>
        <li class="nav-item">
            <a class="nav-link" href="javascript: loadAccountsPage()">
                <i class="fas fa-user"></i>
                <span>Accounts</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="javascript: loadManufacturersPage()">
                <i class="fas fa-industry"></i>
                <span>Manufacturers</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="javascript: loadProductsPage()">
                <i class="fas fa-mobile-alt"></i>
                <span>Products</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="javascript: loadInvoicesPage()">
                <i class="fas fa-money-bill"></i>
                <span>Invoices</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="javascript: loadBannerPage()">
                <i class="fas fa-image"></i>
                <span>Banner</span>
            </a>
        </li>
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
