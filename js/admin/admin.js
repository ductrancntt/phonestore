(function ($) {
    "use strict";
})(jQuery);

function loadAccountsPage() {
    let url = "/js/admin/manage-data/manage-accounts.php?cacheBuster="+ (new Date()).getTime();
    $("#content").load(url);
}

function loadProductsPage() {
    let url = "/js/admin/manage-data/manage-products.php?cacheBuster="+ (new Date()).getTime();
    $("#content").load(url);
}

function loadManufacturersPage() {
    let url = "/js/admin/manage-data/manage-manufacturers.php?cacheBuster="+ (new Date()).getTime();
    $("#content").load(url);
}

function loadInvoicesPage() {
    let url = "/js/admin/manage-data/manage-invoices.php?cacheBuster="+ (new Date()).getTime();
    $("#content").load(url);
}

loadAccountsPage();