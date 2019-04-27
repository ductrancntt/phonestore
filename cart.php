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

    <title>Phone Shop</title>
    <link href="./css/ui.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
include "navbar.php";
?>
<?php
require_once "./service/Connection.php";
function getProductById($id)
{

    $connection = new Connection();
    $connection->createConnection();
    $product = null;

    $sql = "SELECT * FROM product WHERE id = " . $id;
    $result = $connection->excuteQuery($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $product = $row;
        }
    }
    $connection->closeConnection();
    return $product;
}

?>
<div>
    <section class="section-content bg padding-y border-top" style="height: 100vh">
        <div class="container">

            <div class="row">
                <main class="col-sm-9">

                    <div class="card">
                        <table class="table table-hover shopping-cart-wrap">
                            <thead class="text-muted">
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col" width="120">Quantity</th>
                                <th scope="col" width="200">Price</th>
                                <th scope="col" width="120">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sum = 0;
                            foreach ($_SESSION["userCart"] as $item) {
                                $product = getProductById($item["id"]);
                                $sum += $product["price"] * $item["quantity"];
                                echo ' <tr>
                                            <td>
                                                <figure class="media">
                                                    <div class="img-wrap"><img src="' . $product["image"] . '" class="img-thumbnail img-sm"></div>
                                                    <figcaption class="media-body">
                                                        <h6 class="title text-truncate">' . $product["name"] . '</h6>
                                                        <dl class="dlist-inline small">
                                                            <dt>Memory:</dt>
                                                            <dd>'.$product["memory"].'</dd>
                                                        </dl>
                                                        <dl class="dlist-inline small">
                                                            <dt>Screen size:</dt>
                                                            <dd>'.$product["screen_size"].'</dd>
                                                        </dl>
                                                    </figcaption>
                                                </figure>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" disabled value="' . $item["quantity"] . '">
                                            </td>
                                            <td>
                                                <div class="price-wrap">
                                                    <var class="price">' . number_format($product["price"] * $item["quantity"]) . ' đ</var>
                                                    <small class="text-muted">' . number_format($product["price"]) . ' đ/1pcs</small>
                                                </div> <!-- price-wrap .// -->
                                            </td>
                                            <td>
                                                <a href="./service/removeItemCart.php?id=' . $product["id"] . '" class="btn btn-outline-danger"> × Remove</a>
                                            </td>
                                        </tr>';
                            }
                            ?>

                            </tbody>
                        </table>
                    </div> <!-- card.// -->

                </main> <!-- col.// -->
                <aside class="col-sm-3">


                    <dl class="dlist-align h4">
                        <dt>Total:</dt>
                        <dd class="text-right"><strong>đ <?php echo number_format($sum); ?></strong></dd>
                    </dl>
                    <hr>
                    <input <?php if(count($_SESSION["userCart"]) == 0) echo "disabled"; ?> type="button"
                                                                                           onclick="window.location.href = './checkout.php'" class="btn btn-primary btn-block" value="Check Out">

                </aside> <!-- col.// -->
            </div>

        </div> <!-- container .//  -->
    </section>
</div>
<script>
    $(document).ready(function(){
        let url = new URL(window.location.href);
        let success = url.searchParams.get("success");
        if(success == 'true'){
            bootbox.alert("Đặt hàng thành công!", function () {
                window.location.href = "./home.php"
            });

        }else if(success == 'false'){
            bootbox.alert("Đặt hàng chưa thành công! Vui lòng thử lại");
        }
    })
</script>

<?php
include "footer.php";
?>
</body>
</html>
