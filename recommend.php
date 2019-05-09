<?php
/**
 * Created by PhpStorm.
 * User: skull
 * Date: 08/05/2019
 * Time: 11:24
 */
function getRecommendItem()
{
    if (!isset($_SESSION))
        session_start();
    require_once "./service/Connection.php";
    $connection = new Connection();
    $connection->createConnection();
    try {
        mysqli_query($connection->getConnection(), "START TRANSACTION");
        $sql = "SELECT invoice_id, product_id FROM item";
        $result = $connection->excuteQuery($sql);

        $a = array();
        $b = array();

        for ($i = 1; $i <= 50; $i++) {
            $a[$i] = array();
        }

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($a[$row["invoice_id"]], $row["product_id"]);
                if (!in_array($row["invoice_id"], $b)) {
                    array_push($b, $row["invoice_id"]);
                }
            }
        } else {
//            echo "0 results";
        }

//    echo "\n", $a[7][0], "\t\t", $a[7][1], sizeof($b);

        $cart = array();
        foreach ($_SESSION["userCart"] as $item) {
            array_push($cart, $item["id"]);
        }

        if (sizeof($cart) == 0) {
            return;
        }

//        echo "In Cart : ";
//        foreach ($cart as $i) {
//            echo $i . "<br>";
//        }

        $count = array();
        for ($i = 0; $i <= 50; $i++) {
            $count[$i] = 0;
        }
        $product = array();
        if (sizeof($cart) > 0) {
            foreach ($b as $i) {
                $ok = True;
                foreach ($cart as $item) {
                    if (!in_array($item, $a[$i])) {
                        $ok = False;
                        break;
                    }
                }

                if ($ok == True) {
                    foreach ($a[$i] as $item) {
                        if (!in_array($item, $cart)) {
                            $count[$item]++;
                            if (!in_array($item, $product)) {
                                array_push($product, $item);
                            }
                        }
                    }
                }

            }

//            echo "Product and count : <br>";
//            foreach ($product as $i) {
//                echo "Item : ".$i." Count : ".$count[$i]."<br>";
//            }

            for ($i = 0; $i < sizeof($product); $i++) {
                for ($j = $i + 1; $j < sizeof($product); $j++) {
                    if ($count[$product[$i]] < $count[$product[$j]]) {
                        $tmp = $product[$i];
                        $product[$i] = $product[$j];
                        $product[$j] = $tmp;
                    }
                }
            }

//            echo "Product and count after sort : <br>";
//            for ($i = 0 ; $i < sizeof($product); $i++) {
//                echo "Item : ".$product[$i]." Count : ".$count[$product[$i]]."<br>";
//            }
        }
        $image = array();
        $name = array();
        $price = array();

        $sql = "SELECT id, name, price, image FROM product";
        $result = $connection->excuteQuery($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $image[$row["id"]] = $row["image"];
                $name[$row["id"]] = $row["name"];
                $price[$row["id"]] = $row["price"];
            }
        }


        for ($i = 0; $i < min(sizeof($product), 5); $i++) {
//            echo $product[$i];
            echo '<a href="./product-detail.php?id=' . $product[$i] . '"><img src=' . $image[$product[$i]] . ' width="50" height="50" /></a>' . '<br>';
//            echo '<figure class="item border-bottom mb-3">
//                                        <a href="#" class="img-wrap">
//                                            <img th:src="$image[$product[$i]]" class="img-small-wrap">
//                                        </a>
//                                        <figcaption class="info-wrap">
//                                            <a th:href="\'/product/\' + $product[$i]" class="title font-weight-bold"
//                                               th:text="$name[$i]"></a>
//                                            <div class="price-wrap mb-3">
//                                                <span class="price-new"
//                                                      th:text="${#numbers.formatDecimal($price[$i], 0, \'POINT\', 0, \'COMMA\')} + \' ₫\'"></span>
//                                                <del class="price-old"></del>
//                                            </div>
//                                        </figcaption>
//                                    </figure>';
        }


    } catch (Exception $e) {
        print_r($e);
        mysqli_query($connection->getConnection(), "ROLLBACK");
        echo "ROLL BACK";
    }
}
