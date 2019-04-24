(function ($) {

    let startDate = null;
    let endDate = null;
    let topSellersTable = null;
    let selectedStoreId = 0;

    $("#date-range-picker").daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $("#date-range-picker").on('apply.daterangepicker', function (ev, picker) {
        startDate = picker.startDate.format('DD/MM/YYYY');
        endDate = picker.endDate.format('DD/MM/YYYY');
        $(this).val(startDate + ' ~ ' + endDate);
    });

    $("#date-range-picker").on('cancel.daterangepicker', function (ev, picker) {
        startDate = null;
        endDate = null;
        $(this).val('');
    });

    $("#stores").append("<a class='dropdown-item' href='#' data-id='0'>All Stores</a>");
    stores.forEach(function (store) {
        $("#stores").append("<a class='dropdown-item' href='#' data-id='" + store.id + "'>" + store.storeName + "</a>");
    });

    $("#stores a.dropdown-item").click(function () {
        $("#selected-store").text($(this).text());
        $("#selected-store").data("id", $(this).data("id"));
    });

    $("#search").click(function () {
        selectedStoreId = parseInt($("#selected-store").data("id"));
        topSellersTable.ajax.reload();
    });
    
    $("#refresh-button").click(function () {
        selectedStoreId = 0;
        startDate = null;
        endDate = null;
        $("#selected-store").text("All Stores");
        $("#selected-store").data("id", 0);
        $("#date-range-picker").val("");
        topSellersTable.ajax.reload();
    });

    let renderTable = function () {
        topSellersTable = $("#top-sellers-table").DataTable({
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
                    "storeId": selectedStoreId,
                    "startDate": startDate,
                    "endDate": endDate
                };

                $.get("/api/top-sellers", params, function (response) {
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
                }
            ],
            "columnDefs": [
                {
                    "render": function (data, type, row, meta) {
                        return meta.row + 1;
                    },
                    "targets": 0
                },
                {
                    "render": function (data) {
                        return data.productName;
                    },
                    "targets": 1
                },
                {
                    "render": function (data) {
                        return "<img src='" + data.url + "' style='max-width: 5vw'/>";
                    },
                    "targets": 2
                },
                {
                    "render": function (data) {
                        return data.total + " pcs";
                    },
                    "targets": 3
                },
                {
                    "render": function (data) {
                        return formatNumber(data.revenue) + " ₫";
                    },
                    "targets": 4
                }
            ],
            drawCallback: function () {

            }
        });

    }

    renderTable();

})(jQuery);