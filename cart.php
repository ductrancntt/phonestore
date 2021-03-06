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
    <section class="section-content bg padding-y border-top" style="height: 100vh; overflow-y: scroll">
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
                                                <input min="1" type="number" id="product_' . $item["id"] . '" onchange="javascript:changeNumber(' . $item["id"] .')" class="form-control" value="' . $item["quantity"] . '">
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
                         onclick="thanhtoan()" class="btn btn-primary btn-block" value="Check Out">

                </aside> <!-- col.// -->
            </div>

        </div> <!-- container .//  -->
    </section>
</div>
<?php 
    require_once "./service/getProvice.php"

?>
<script>
    let changeNumber = function(id){
        let quantity = $("#product_" + id).val();

        if (quantity <= 0){
            $("#product_" + id).val(1);
            quantity = 1;
        }
        let params = {
            change: "change",
            id: id,
            quantity: quantity
        }
        if (id){
            console.log("sent");
            $.post("./service/updateSession.php", params, function (res) {
                console.log(res);
                window.location.href = "./cart.php";
            })
        }
    }
    let tinhThanh = <?php echo getProvice(); ?> 
    let option = '';
    tinhThanh.forEach(function(e){
        option += `<option value="${e.matp}">${e.name}</option>`;
    })
    function getQuanHuyen(){
        let id = $('#tp').val();
        console.log(id);
        
        $.ajax({
            url: './service/getDistrict.php?id='+id,
            type: 'GET',
            success: function(res){
                html = ''
                JSON.parse(res).forEach(function(e){
                    html += `<option value='${e.maqh}'>${e.name}</option>`
                    $('#huyen').html(html)
                })
            }
        })
    }
    function thanhtoan(){
        bootbox.dialog({
            title: 'Ship Address',
            message: `
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-title">Province&nbsp;<span style="color: red">*</span></span>
                    </div>
                    <select onchange="getQuanHuyen()" class="form-control font-responsive" id="tp">
                    ${option}
                    </select>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text input-title">District&nbsp;<span style="color: red">*</span></span>
                    </div>
                    <select class="form-control font-responsive" id="huyen">
                        
                    </select>
                </div>
                <div class="input-group mb-3">
                <div class="input-group-prepend">
                        <span class="input-group-text input-title">Home Address&nbsp;<span style="color: red">*</span></span>
                    </div>
                    <input id="addr" title="Home Address" class="form-control font-responsive">
                </div>
            `,
            buttons:{
                cancel: {
                    label: "Cancel",
                    className: 'btn-danger',
                    callback: function(){
                    }
                },
                ok: {
                    label: "OK",
                    className: 'btn-success',
                    callback: function(){
                        let addr = $('#addr').val().trim();
                        let tp = $("#tp option:selected").text().trim();
                        let huyen = $('#huyen option:selected').text().trim();
                        if(!addr){
                            AlertService.error("Please fill all required fields(*)");
                            return false;
                        }
                        let t = addr+', '+huyen+', '+ tp;
                        window.location.href = './checkout.php?diachi='+ t
                    }
                },
            },
            closeButton: false
        });
        getQuanHuyen()
        
    }
    $(document).ready(function(){
        let url = new URL(window.location.href);
        let success = url.searchParams.get("success");
        if(success == 'true'){
            bootbox.alert("Order Successfully!", function () {
                window.location.href = "./home.php"
            });

        }else if(success == 'false'){
            bootbox.alert("Error Occurs! Please try again!");
        }
    })
</script>

<?php
include "footer.php";
?>
</body>
</html>
