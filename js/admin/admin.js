(function ($) {
    "use strict";
})(jQuery);

function loadAccountsPage() {
    $("#content").load("/js/admin/manage-data/manage-accounts.php");
}

function loadProductsPage() {
    $("#content").load("/js/admin/manage-data/manage-products.php");
}

function loadManufacturersPage() {
    $("#content").load("/js/admin/manage-data/manage-manufacturers.php");
}

loadAccountsPage();