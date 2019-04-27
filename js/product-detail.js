(function ($) {

    $("#product-image").on('mouseover', function () {
        $(this).css({'transform': 'scale(' + $(this).attr('data-scale') + ')'});
    }).on('mouseout', function () {
        $(this).css({'transform': 'scale(1)'});
    }).on('mousemove', function (e) {
        $(this).css({'transform-origin': ((e.pageX - $(this).offset().left) / $(this).width()) * 100 + '% ' + ((e.pageY - $(this).offset().top) / $(this).height()) * 100 + '%'});
    });

    let rating = 0;

    $("button.btn.btn-primary.btn-add-to-cart").click(function () {
        let currentCart = JSON.parse(sessionStorage.getItem("userCart"));

        let cartMap = currentCart.reduce((map, product) => {
            return map.set(product.productId, product.quantity);
        }, new Map());

        let productId = $(this).data("id");

        let q = parseInt($("#quantity-input").val());

        if (cartMap.has(productId)) {
            let quantity = parseInt(cartMap.get(productId));
            quantity += q;
            cartMap.set(productId, quantity);
        } else {
            cartMap.set(productId, q);
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

    $("#review-button").click(function () {
        $.get("/api/ratings/get-customer-rating", {productId: $(this).data("id")}, function (response) {
            rating = response.rating;
            $("#review-stars>i.fa.fa-star").removeClass("rating-star-active");
            for (let i = 1; i <= rating; i++) {
                $("#" + i).addClass("rating-star-active");
            }
            $("#review-comment").val(response.comment);
        }).fail(function () {
            rating = 0;
            $("#review-stars>i.fa.fa-star").removeClass("rating-star-active");
        });
        $("#review-modal").modal("show");
    });

    $("#submit-review").click(function () {
        let productId = $(this).data("id");

        $.post("/api/ratings", {
            rating: rating,
            comment: $("#review-comment").val(),
            productId: productId
        }, function () {
            $.get("/api/ratings/get-average-rating", {productId: productId}, function (response) {
                $("#active-rating-stars").remove();
                ($("#avg-rating").children()).removeClass("rating-star-active");
                ($("#avg-rating").children()).each(function (index) {
                    if (index < response.avgRating) {
                        $(this).addClass("rating-star-active");
                    }
                });
                $("#total-reviews").text(response.totalRating + " reviews");
                loadCustomerReviews();
            });
        });

        $("#review-modal").modal("hide");
    });

    $("#review-stars>i.fa.fa-star").hover(function () {
        $("#review-stars>i.fa.fa-star").removeClass("rating-star-active");
        for (let i = 1; i <= $(this).attr("id"); i++) {
            $("#" + i).addClass("rating-star-active");
        }
    }, function () {
        $("#review-stars>i.fa.fa-star").removeClass("rating-star-active");
        for (let i = 1; i <= rating; i++) {
            $("#" + i).addClass("rating-star-active");
        }
    });

    $("#review-stars>i.fa.fa-star").click(function () {
        rating = parseInt($(this).attr("id"));
    });

    let loadCustomerReviews = function () {
        $.get("/api/public/ratings/get-all-reviews-product", {productId: $("#review-button").data("id")}, function (response) {
            if (response.length > 0) {
                $("#customer-reviews").empty();
                response.forEach(function (review) {
                    let content = "<div class='row' style='padding-bottom: 10px;'>" +
                        "<div class='col-md-6 h5 text-primary'>" + review.customerName + "</div>" +
                        "<div class='col-md-6'>" +
                        "<ul class='rating-stars float-right'>" +
                        "<li>";
                    for (let i = 0; i < 5; i++) {
                        if (i < review.rating)
                            content += "<i class='fa fa-star rating-star-active'></i>";
                        else
                            content += "<i class='fa fa-star'></i>";
                    }
                    content += "</li>" +
                        "</ul>" +
                        "</div>" +
                        "<div class='col-md-12'>" +
                        "<p class='border-top border-primary'>" + review.comment + "</p>" +
                        "</div>" +
                        "<div class='col-md-12'>" +
                        "<span class='float-right text-secondary'>" + review.createdDate + "</span>" +
                        "</div>" +
                        "</div>";
                    $("#customer-reviews").append(content);
                });
            }
        });
    }

    let addToWishListListener = function () {
        $("button.btn.wish-list.btn-add-to-wish-list").off("click");
        $("button.btn.wish-list.btn-add-to-wish-list").click(function () {
            $(this).tooltip('dispose');
            let id = $(this).data("id");
            $.post("/api/wish-list/add", {productId: id}, function () {
                updateNumberWishList();
                $("button.btn.wish-list.btn-add-to-wish-list[data-id='" + id + "']").replaceWith("<button type='button' class='btn btn-remove-wish-list' data-toggle='tooltip' data-placement='top' title='Remove from Wishlist' data-id='" + id + "'>" +
                    "<i class='fas fa-heart'></i>" +
                    "</button>");
                removeFromWishListListener();
                $("button[data-toggle='tooltip']").tooltip();
            });
        });
    }

    let removeFromWishListListener = function () {
        $("button.btn.btn-remove-wish-list").off("click");
        $("button.btn.btn-remove-wish-list").click(function () {
            $(this).tooltip('dispose');
            let id = $(this).data("id");
            $.post("/api/wish-list/remove", {productId: id}, function () {
                updateNumberWishList();
                $("button.btn.btn-remove-wish-list[data-id='" + id + "']").replaceWith("<button type='button' class='btn wish-list btn-add-to-wish-list' data-toggle='tooltip' data-placement='top' title='Add to Wishlist' data-id='" + id + "'>" +
                    "<i class='far fa-heart'></i>" +
                    "</button>");
                addToWishListListener();
                $("button[data-toggle='tooltip']").tooltip();
            });
        });
    }

    loadCustomerReviews();
    addToWishListListener();
    removeFromWishListListener();

})(jQuery);