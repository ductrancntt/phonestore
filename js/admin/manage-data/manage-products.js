(function ($) {
    $(document).ready(function () {
        CKEDITOR.config.height = 100;
        CKEDITOR.replace('product-description');
    })

    let manufacturerList = [];
    let productTable = null;
    let searchName = "";
    let image = null;
    let products = [];

    let productUrl = "/js/admin/manage-data/product.php";
    let manufacturerUrl = "/js/admin/manage-data/manufacturer.php";

    let loadManufacturers = function () {
        $.get(manufacturerUrl, {getAll: "getAll"}, function (response) {
            manufacturerList = response;
            $("#manufacturer-selector").empty();
            manufacturerList.forEach(function (manufacturer) {
                $("#manufacturer-selector").append("<option value='" + manufacturer.id + "'>" + manufacturer.name + "</option>");
            });
        });
    }

    let renderTable = function () {
        console.log("x");
        productTable = $("#product-table").DataTable({
            "pageLength": 10,
            "lengthMenu": [[10, 20, 30], [10, 20, 30]],
            "scrollX": false,
            "serverSide": true,
            "ordering": false,
            "bFilter": false,
            "language": {
                "oPaginate": {
                    sNext: "<i class='fas fa-angle-right'></i>",
                    sPrevious: "<i class='fas fa-angle-left'></i>"
                }
            },
            "ajax": function (requestParams, render) {
                let params = {
                    "getAll": "getAll",
                    "page": (requestParams.start / requestParams.length) + 1,
                    "limit": requestParams.length,
                    "search": searchName
                };
                $.get(productUrl, params, function (response) {
                    products = response;
                    console.log(products);
                    render({
                        "draw": requestParams.draw,
                        "recordsTotal": response.totalElements,
                        "recordsFiltered": response.totalElements,
                        "data": response.data
                    });
                });
            },
            "columns": [
                {
                    "data": null,
                    "className": 'align-middle bold font-responsive'
                },
                {
                    "data": null,
                    "className": 'align-middle font-responsive'
                },
                {
                    "data": null,
                    "className": 'align-middle font-responsive'
                },
                {
                    "data": null,
                    "className": 'align-middle font-responsive'
                },
                {
                    "data": null,
                    "className": 'align-middle font-responsive'
                },
                {
                    "data": null,
                    "className": 'align-middle font-responsive'
                },
                {
                    "data": null,
                    "className": 'align-middle font-responsive'
                },
                {
                    "data": null,
                    "className": 'align-middle font-responsive'
                },
                {
                    "data": null,
                    "className": 'align-middle font-responsive'
                },
                {
                    "data": null,
                    "className": 'align-middle'
                },
                {
                    "data": null,
                    "className": 'align-middle'
                }
            ],
            "columnDefs": [
                {
                    "render": function (data) {
                        return data.id;
                    },
                    "targets": 0
                },
                {
                    "render": function (data) {
                        return data.name;
                    },
                    "targets": 1
                },
                {
                    "render": function (data) {
                        return formatNumber(data.price) + " ₫";

                    },
                    "targets": 2
                },
                {
                    "render": function (data) {
                        return data.description;
                    },
                    "targets": 3
                },
                {
                    "render": function (data) {
                        return data.screen_size + " inch";
                    },
                    "targets": 4
                },
                {
                    "render": function (data) {
                        return data.memory + " GB";
                    },
                    "targets": 5
                },
                {
                    "render": function (data) {
                        return data.chipset;
                    },
                    "targets": 6
                },
                {
                    "render": function (data) {
                        return "<img src='" + data.image + "' style='max-width: 5vw'/>";
                    },
                    "targets": 7
                },
                {
                    "render": function (data) {
                        let manu = {};
                        for (let i = 0; i < manufacturerList.length; i++) {
                            if (manufacturerList[i].id == data.manufacturer_id) {
                                manu = manufacturerList[i];
                                break;
                            }
                        }
                        return manu.name;
                    },
                    "targets": 8
                },
                {
                    "render": function (data) {
                        return data.quantity + " pcs";
                    },
                    "targets": 9
                },
                {
                    "render": function (data) {
                        return "<div class='table-right-button'>" +
                            "<button type='button' class='btn btn-info btn-table-product font-responsive' data-id='" + data.id + "' style='margin-right: 10px;' data-toggle='modal' data-target='#product-modal'>" +
                            "<i class='fas fa-pen'></i>" +
                            "</button>" +
                            "<button type='button' class='btn btn-danger btn-table-product font-responsive' data-id='" + data.id + "' data-toggle='modal' data-target='#product-delete-modal'>" +
                            "<i class='fas fa-times'></i>" +
                            "</button>" +
                            "</div>";
                    },
                    "targets": 10
                }
            ],
            drawCallback: function () {
                $("button.btn.btn-info.btn-table-product").click(function () {
                    $("#product-modal-title").text("Edit Product");
                    loadProductInfo($(this).data("id"));
                });
                $("button.btn.btn-danger.btn-table-product").click(function () {
                    $.get("/api/product-stores/" + $(this).data("id"), function (response) {
                        productStore = response;
                    });
                });
            }
        });

        productTable.fixedHeader.enable(true);
    }

    $("#save-product").click(function () {
        let productName = $("input[name='product-name']").val();
        let price = $("input[name='price']").val();
        let screenSize = $("input[name='screen-size']").val();
        let description = $("textarea[name='product-description']").val();
        let manufacturerId = $("#manufacturer-selector").val();

        if (productStore == null) {
            let productStores = [];
            stores.forEach(function (store) {
                let quantity = $("#" + store.id).val();
                productStores.push({
                    id: null,
                    productId: null,
                    storeId: store.id,
                    quantity: quantity
                });
            });
            productStore = {
                product: {
                    id: null,
                    manufacturerId: manufacturerId,
                    productName: productName,
                    price: price,
                    screenSize: screenSize,
                    description: description,
                    url: "image/no_image.png",
                    deleted: false
                },
                productStores: productStores
            }
        } else {
            let storeId = productStore.store.id;
            let quantity = $("#" + storeId).val();
            let productId = productStore.product.id;
            let url = productStore.product.url;
            let productStores = [];
            productStores.push({
                id: productStore.id,
                productId: productId,
                storeId: storeId,
                quantity: quantity
            });
            productStore = {
                product: {
                    id: productId,
                    manufacturerId: manufacturerId,
                    productName: productName,
                    price: price,
                    screenSize: screenSize,
                    description: description,
                    url: url,
                    deleted: false
                },
                productStores: productStores
            }
        }

        let formData = new FormData();
        formData.append("image", image);
        formData.append("product", new Blob([JSON.stringify(productStore)], {type: "application/json"}));

        $.ajax({
            type: "POST",
            url: "/api/product-stores",
            data: formData,
            contentType: false,
            processData: false,
            success: function () {
                productTable.ajax.reload();
            },
            error: function () {
                productTable.ajax.reload();
            }
        });

        $("#product-modal").modal('hide');
    });

    $("#delete-product").click(function () {
        $.post("/api/products/delete/" + productStore.product.id, function () {
            productTable.ajax.reload();
        });

        $("#product-delete-modal").modal('hide');
    });

    $("button[data-target='#product-modal']").click(function () {
        productStore = null;
        $("#product-modal-title").text("Add Product");
        $("input[name='product-name']").val("");
        $("input[name='price']").val("100000");
        $("input[name='screen-size']").val("3.0");
        $("textarea[name='product-description']").val("");
        $("#product-store-quantity").empty();

        stores.forEach(function (store) {
            $("#product-store-quantity").append("<div class='input-group mb-3'>" +
                "<div class='input-group-prepend'>" +
                "<span class='input-group-text input-title'>" + store.storeName + "</span>" +
                "</div>" +
                "<input type='number' min='0' class='form-control font-responsive' id='" + store.id + "' value='0'>" +
                "<div class='input-group-append'><span class='input-group-text font-responsive'>pcs</span></div>" +
                "</div>");
        });
    });

    $("#search-product-button").click(function () {
        selectedStoreId = parseInt($("#selected-store-product-tab").data("id"));
        productNameSearch = $("#product-search-input").val();
        productTable.ajax.reload();
    });

    $("#product-refresh-button").click(function () {
        selectedStoreId = 0;
        $("#selected-store-product-tab").text("All Stores");
        $("#selected-store-product-tab").data("id", 0);
        productNameSearch = "";
        $("#product-search-input").val(productNameSearch);
        productTable.ajax.reload();
    });

    $("#image-input").change(function () {
        image = this.files[0];
    });

    loadManufacturers();

    renderTable();

})(jQuery);