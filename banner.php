<?php
require_once "./service/Connection.php";
if (!isset($connection)) {
    $connection = new Connection();
}
$connection->createConnection();

$sql = "SELECT * FROM banner WHERE enable = 1";

$result = $connection->excuteQuery($sql);
$bannerList = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $banner = ["image" => $row["image"], "link" => $row["link"]];
        array_push($bannerList, $banner);
    }
    $connection->closeConnection();

} else {
    $connection->closeConnection();
}
?>
<?php
$connection->createConnection();
define("BANNER_TIME", "BANNER_TIME");
$sql = "SELECT * FROM setting WHERE name = '" . BANNER_TIME . "'";

$result = $connection->excuteQuery($sql);
$time = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $time = $row["value"];
    }
    $connection->closeConnection();

} else {
    $connection->closeConnection();
}
?>
<section>
    <div class="banner" style="background-color:  #f8f8f8">
        <div class="container">
            <div id="carousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ul class="carousel-indicators">
                    <?php
                    for ($i = 0; $i < count($bannerList); $i++) {
                        if ($i == 0) {
                            echo '<li data-target="#carousel" data-slide-to="0" class="active"></li>';
                        } else {
                            echo '<li data-target="#carousel" data-slide-to="' . $i . '"></li>';
                        }
                    }
                    ?>
                </ul>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <?php
                    for ($i = 0; $i < count($bannerList); $i++) {
                        if ($i == 0) {
                            echo '<div class="carousel-item active">
                            <img src="' . $bannerList[$i]["image"] . '" alt="" style="width:100%; height: 300px;">
                            <div class="carousel-caption">
                            
                            </div>
                        </div>';
                        } else {
                            echo '<div class="carousel-item">
                            <img src="' . $bannerList[$i]["image"] . '" alt="Chicago" style="width:100%;height: 300px;">
                            <div class="carousel-caption">
                            </div>
                        </div>';
                        }
                    }
                    ?>
                </div>

                <!-- Left and right controls -->
                <a class="carousel-control-prev" href="#carousel" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next" href="#carousel" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>
            </div>
            <script>
                $(document).ready(function () {
                    $('.carousel').carousel({
                        interval: <?php echo $time;?>
                    });
                })
            </script>
        </div>
    </div>
</section>


