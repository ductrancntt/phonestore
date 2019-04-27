<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<script type="text/javascript" src="./libs/jquery/jquery-3.3.1.min.js"></script>
<link rel="stylesheet" href="./libs/bootstrap/css/bootstrap.min.css"/>
<script type="text/javascript" src="./libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="./js/bootbox.all.min.js"></script>
<link rel="stylesheet" href="./libs/fontawesome/css/all.css"/>
<link rel="stylesheet" href="./css/main.css"/>

<link rel="icon" href="./image/favicon.png">
<?php if (!isset($_SESSION))
    session_start(); ?>
<script type="text/javascript">
    $(function () {
        $("button[data-toggle='tooltip']").tooltip();
    });

    let formatNumber = function(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>