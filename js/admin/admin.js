(function ($) {
    "use strict";
})(jQuery);

function loadAccountsPage() {
    $("#content").load("/js/admin/manage-data/manage-accounts.html");
}

function loadProductsPage() {
    $("#content").load("/js/admin/manage-data/manage-products.html");
}

function loadManufacturersPage() {
    $("#content").load("/js/admin/manage-data/manage-manufacturers.html");
}


loadAccountsPage();