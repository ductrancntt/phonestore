(function ($) {
    "use strict";

    $("#sidebarToggle, #sidebarToggleTop").on('click', function (e) {
        $("body").toggleClass("sidebar-toggled");
        $(".sidebar").toggleClass("toggled");
        if ($(".sidebar").hasClass("toggled")) {
            $('.sidebar .collapse').collapse('hide');
        }
    });

    $(window).resize(function () {
        if ($(window).width() < 768) {
            $('.sidebar .collapse').collapse('hide');
        }
    });

    $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function (e) {
        if ($(window).width() > 768) {
            let e0 = e.originalEvent,
                delta = e0.wheelDelta || -e0.detail;
            this.scrollTop += (delta < 0 ? 1 : -1) * 30;
            e.preventDefault();
        }
    });

    $(document).on('scroll', function () {
        let scrollDistance = $(this).scrollTop();
        if (scrollDistance > 100) {
            $('.scroll-to-top').fadeIn();
        } else {
            $('.scroll-to-top').fadeOut();
        }
    });

    $(document).on('click', 'a.scroll-to-top', function (e) {
        let $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: ($($anchor.attr('href')).offset().top)
        }, 1000, 'easeInOutExpo');
        e.preventDefault();
    });

    $("a.nav-link").click(function () {
        $($("a.nav-link").parent()).removeClass('active');
        if ($("#tables-link").hasClass('show'))
            $("#tables-link").collapse('toggle');
        $($(this).parent()).addClass('active');
    });

})(jQuery);

let loadEmployeesPage = function () {
    $("#content").load("/js/admin/manage-data/manage-employees.html");
}

let loadProductsPage = function () {
    $("#content").load("/js/admin/manage-data/manage-products.html");
}

let loadManufacturersPage = function () {
    $("#content").load("/js/admin/manage-data/manage-manufacturers.html");
}

let loadCustomersPage = function () {
    $("#content").load("/js/admin/manage-data/manage-customers.html");
}

let loadInvoicesPage = function () {
    $("#content").load("/js/admin/manage-data/manage-invoices.html");
}

let loadRevenuePage = function () {
    $("#content").load("/js/admin/revenue/revenue.html");
}

let loadTopSellersPage = function () {
    $("#content").load("/js/admin/top-sellers/top-sellers.html");
}

let loadDashboardPage = function () {
    $("#content").load("/js/admin/dashboard/dashboard.html");
}

let stores = [];

let initStores = function () {
    $.get("/api/stores", function (response) {
        stores = response;
    });
}

initStores();

loadDashboardPage();