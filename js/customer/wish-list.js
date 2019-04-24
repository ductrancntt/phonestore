(function ($) {

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

    $("button.btn.btn-remove").click(function () {
        let id = $(this).data("id");
        $.post("/api/wish-list/remove", {productId: id}, function () {
            $("#id-" + id).remove();
            updateNumberWishList();
            let total = parseInt($("#total-products").text());
            total--;
            $("#total-products").text(total);
        });
    });

    $("button.btn.btn-primary.btn-add-to-cart").click(function () {
        let currentCart = JSON.parse(sessionStorage.getItem("userCart"));

        let cartMap = currentCart.reduce((map, product) => {
            return map.set(product.productId, product.quantity);
        }, new Map());

        let productId = $(this).data("id");

        if (cartMap.has(productId)) {
            let quantity = parseInt(cartMap.get(productId));
            quantity++;
            cartMap.set(productId, quantity);
        } else {
            cartMap.set(productId, 1);
        }

        currentCart = [];
        cartMap.forEach(function (value, key) {
            currentCart.push({
                productId: key,
                quantity: value
            });
        });

        sessionStorage.setItem("userCart", JSON.stringify(currentCart));
        updateNumberCart();
    });

})(jQuery);