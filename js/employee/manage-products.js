(function ($) {

    let productTable = null;
    let productStore = null;
    let productNameSearch = "";

    let loadProductInfo = function (id) {
        $.get("/api/employees/product-store/" + id, function (response) {
            productStore = response;
            $("input[type='number']").val(productStore.quantity);
        });
    }

    let renderTable = function () {
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
                    "page": (requestParams.start / requestParams.length) + 1,
                    "limit": requestParams.length,
                    "storeId": store.id,
                    "name": productNameSearch
                };
                $.get("/api/product-stores/page", params, function (response) {
                    render({
                        "draw": requestParams.draw,
                        "recordsTotal": response.totalElements,
                        "recordsFiltered": response.totalElements,
                        "data": response.content
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
                    "className": 'align-middle'
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
                        return data.product.productName;
                    },
                    "targets": 1
                },
                {
                    "render": function (data) {
                        return "<img src='" + data.product.url + "' style='max-width: 5vw'/>";
                    },
                    "targets": 2
                },
                {
                    "render": function (data) {
                        return data.manufacturer.manufacturerName;
                    },
                    "targets": 3
                },
                {
                    "render": function (data) {
                        return data.product.screenSize + " inch";
                    },
                    "targets": 4
                },
                {
                    "render": function (data) {
                        return formatNumber(data.product.price) + " ₫";
                    },
                    "targets": 5
                },
                {
                    "render": function (data) {
                        return data.quantity + " pcs";
                    },
                    "targets": 6
                },
                {
                    "render": function (data) {
                        return data.product.description;
                    },
                    "targets": 7
                },
                {
                    "render": function (data) {
                        return "<div class='table-right-button'>" +
                            "<button type='button' class='btn btn-info btn-table-product font-responsive' data-id='" + data.id + "' style='margin-right: 10px;' data-toggle='modal' data-target='#product-modal'>" +
                            "<i class='fas fa-pen'></i>" +
                            "</button>" +
                            "</div>";
                    },
                    "targets": 8
                }
            ],
            drawCallback: function () {
                $("button.btn.btn-info.btn-table-product").click(function () {
                    loadProductInfo($(this).data("id"));
                });
            }
        });
    }

    $("#save-product").click(function () {
        productStore.quantity = $("input[type='number']").val();

        $.ajax({
            type: "POST",
            url: "/api/employees/update-product-store",
            data: JSON.stringify(productStore),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function () {
                productTable.ajax.reload();
            },
            error: function () {
                productTable.ajax.reload();
            }
        });

        $("#product-modal").modal('hide');
    });

    $("#search-product-button").click(function () {
        productNameSearch = $("#product-search-input").val();
        productTable.ajax.reload();
    });

    $("#product-refresh-button").click(function () {
        productNameSearch = "";
        $("#product-search-input").val(productNameSearch);
        productTable.ajax.reload();
    });

    renderTable();

})(jQuery);