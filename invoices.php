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
<?php
require_once "./service/Connection.php";

if (isset($_SESSION["user_id"])) {
    $invoiceList = array();
    $connection = new Connection();
    $connection->createConnection();
    $sql = "SELECT * FROM invoice WHERE user_id = " . $_SESSION["user_id"] . " ORDER BY created_date DESC";
    $result = $connection->excuteQuery($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($invoiceList, $row);
        }
    }
    $itemList = array();
    if (isset($_GET["id"])) {
        $sql = "SELECT item.*, product.name as name FROM item JOIN product ON product.id = item.product_id WHERE invoice_id = " . $_GET["id"];
        $result = $connection->excuteQuery($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($itemList, $row);
            }
        }
    }
    $connection->closeConnection();
}


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

        <li class="nav-item active">
            <a class="nav-link" href="./invoices.php">
                <i class="fas fa-file-invoice-dollar"></i>
                <span> Your Orders</span>
            </a>
        </li>
        <hr class="sidebar-divider d-none d-md-block">
    </ul>

    <div id="content-wrapper" class="d-flex flex-column" style="padding-top: 15px">
        <div class="container" id="content">
            <h3>Your Orders</h3>
            <div class="table-responsive">
                <table class="table table-hover" id="invoice-table" width="100%" cellspacing="0">
                    <thead class="table-header">
                    <tr>
                        <th scope="col">ID</th>
                        <th style="text-align: right" scope="col">Created Date</th>
                        <th  style="text-align: right" scope="col">Total</th>
                        <th style="text-align: right">Status</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($invoiceList as $invoice) {
                        $ymd = DateTime::createFromFormat('YmdHis', $invoice["created_date"])->format('d/m/Y H:i:s');

                        echo '<tr>
                            <th>' . $invoice["id"] . '</th>
                            <th style="text-align: right">' . $ymd . '</th>
                            <th  style="text-align: right">' . number_format($invoice["total"]) . ' đ</th>
                            <th style="text-align: right"><button type="button" disabled class="btn '
                            . ($invoice["status"] == 0 ? 'btn-primary"> Ordered' : ($invoice["status"] == 1 ? 'btn-warning"> Delivering' : ($invoice["status"] == 2 ? 'btn-success"> Delivered' : 'btn-danger"> Cancelled'))) .
                            '</button></th>
                            <th style="text-align: center"><button type="button" class="btn btn-primary" onclick="loadInvoiceDetail(' . $invoice["id"] . ')">Detail</button>';
                        if($invoice["status"] != 3){
                            echo '   <button type="button" class="btn btn-danger" onclick="cancel(' . $invoice["id"] . ')">Cancel</button>';
                        }
                        echo '</th></tr>';
                    }
                    ?>

                    </tbody>
                </table>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                let display = false;
                display = <?php if (isset($_SESSION["user_id"]) && isset($_GET["id"])) echo "true";
                else echo "false"; ?>;
                if (display) {
                    $('#run').click();
                }
                let url = new URL(window.location.href);
                let huy = url.searchParams.get("huy");
                if(huy == 'success'){
                    bootbox.alert("Order has been cancelled!");

                }
            })

            function cancel(id) {
                bootbox.confirm("Do you want to cancel this order?", function (r) {
                    if (r) {
                        window.location.href = "./service/cancel.php?id=" + id;
                    }
                })
            }

            function loadInvoiceDetail(id) {
                window.location.href = "./invoices.php?id=" + id;
            }
        </script>
        <button id="run" type='button' class='btn btn-info btn-table-invoice font-responsive'
                style='margin-right: 10px; display: none' data-toggle='modal' data-target='#invoice-modal'>
        </button>
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
                            <tbody>
                            <?php
                            $sum = 0;
                            for ($i = 0; $i < count($itemList); $i++) {
                                $item = $itemList[$i];
                                $sum += $item["quantity"] * $item["order_price"];
                                echo '<tr> 
                                        <th scope="col">' . ($i + 1) . '</th>
                                        <th scope="col">' . $item["name"] . '</th>
                                        <th style="text-align: right" scope="col">' . number_format($item["order_price"]) . ' đ</th>
                                        <th style="text-align: right" scope="col">' . $item["quantity"] . '</th>
                                        <th style="text-align: right" scope="col">' . number_format($item["quantity"] * $item["order_price"]) . ' đ</th>
                                    </tr>';
                            }
                            echo "<tr><th  colspan='4' scope='col' style='text-align: center'>Total Invoice</th><td  style=\"text-align: right\">" . number_format($sum) . " ₫</td></tr>";
                            ?>
                            </tbody>
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
</body>
</html>