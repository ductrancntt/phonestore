<?php
    require "Connection.php";
    if (!isset($_SESSION))
        session_start();

    if (!(isset($_SESSION['signedIn']) && $_SESSION['signedIn'])) {
        header("location:./index.php");
    }

    $userId = $_SESSION['user_id'];

    $startDate = isset($_GET['startDate']) ? json_decode($_GET['startDate']) : null;
    $endDate = isset($_GET['endDate']) ? json_decode($_GET['endDate']) : null;

    $connection = new Connection;
    $connection->createConnection();

    $getInvoicesQuery = "SELECT invoice.id, user.name, SUM(item.order_price * quantity),invoice.created_date FROM user JOIN invoice ON user.id = invoice.user_id JOIN item ON invoice.id = item.invoice_id";
    if ($startDate != null && $endDate != null)
        $getInvoicesQuery .= " WHERE invoice.created_date BETWEEN ".$startDate." AND ".$endDate;
    $getInvoicesQuery .= " GROUP BY invoice.id ORDER BY invoice.created_date";

    $result = $connection->excuteQuery($getInvoicesQuery);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

        }
    }
?>