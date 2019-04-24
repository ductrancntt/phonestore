(function ($) {

    let invoiceTable = null;
    let invoiceDetail = null;
    let startDate = null;
    let endDate = null;
    let customerNameSearch = "";
    let selectedStoreId = 0;

    let loadInvoiceDetail = function (id) {
        $.get("/api/invoices/" + id, function (response) {
            invoiceDetail = response;
            $("#invoice-detail-table tbody").empty();
            invoiceDetail.items.forEach(function (item, index) {
                let row = "<tr>";
                row += "<th scope='row'>" + (index + 1) + "</th>";
                row += "<td>" + item.product.productName + "</td>";
                row += "<td>" + formatNumber(item.price) + " ₫</td>";
                row += "<td>" + item.quantity + " pcs</td>";
                row += "<td>" + formatNumber(item.price * item.quantity) + " ₫</td>";
                row += "</tr>";
                $("#invoice-detail-table tbody").append(row);
            });
            $("#invoice-detail-table tbody").append("<tr><th colspan='4' scope='col' style='text-align: center'>Total Invoice</th><td>" + formatNumber(invoiceDetail.total) + " ₫</td></tr>");
        });
    }

    let renderTable = function () {
        invoiceTable = $("#invoice-table").DataTable({
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
                    "customerName": customerNameSearch,
                    "startDate": startDate,
                    "endDate": endDate
                };

                $.get("/api/invoices/page", params, function (response) {
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
                        return data.customer.customerName;
                    },
                    "targets": 1
                },
                {
                    "render": function (data) {
                        if (data.employee != null)
                            return data.employee.employeeName;
                        else
                            return "";
                    },
                    "targets": 2
                },
                {
                    "render": function (data) {
                        return formatNumber(data.total) + " ₫";
                    },
                    "targets": 3
                },
                {
                    "render": function (data) {
                        return data.store.storeName;
                    },
                    "targets": 4
                },
                {
                    "render": function (data) {
                        return data.createdDate;
                    },
                    "targets": 5
                },
                {
                    "render": function (data) {
                        if (data.customer.online) {
                            return "<span class='badge badge-success'>Online</span>";
                        } else {
                            return "<span class='badge badge-secondary'>Offline</span>";
                        }
                    },
                    "targets": 6
                },
                {
                    "render": function (data) {
                        return "<div class='table-right-button'>" +
                            "<button type='button' class='btn btn-info btn-table-invoice font-responsive' data-id='" + data.id + "' style='margin-right: 10px;' data-toggle='modal' data-target='#invoice-modal'>" +
                            "<i class='fas fa-eye'></i>" +
                            "</button>" +
                            "</div>";
                    },
                    "targets": 7
                }
            ],
            drawCallback: function () {
                $("button.btn.btn-info.btn-table-invoice").click(function () {
                    loadInvoiceDetail($(this).data("id"));
                });
            }
        });
    }

    let initInvoiceTab = function () {
        $("#stores-invoice-tab").append("<a class='dropdown-item' href='#' data-id='0'>All Stores</a>");
        stores.forEach(function (store) {
            $("#stores-invoice-tab").append("<a class='dropdown-item' href='#' data-id='" + store.id + "'>" + store.storeName + "</a>");
        });

        $("#stores-invoice-tab a.dropdown-item").click(function () {
            $("#selected-store-invoice-tab").text($(this).text());
            $("#selected-store-invoice-tab").data("id", $(this).data("id"));
        });
    }

    $("#search-invoice-button").click(function () {
        selectedStoreId = parseInt($("#selected-store-invoice-tab").data("id"));
        customerNameSearch = $("#invoice-search-input").val();
        invoiceTable.ajax.reload();
    });

    $("#invoice-refresh-button").click(function () {
        selectedStoreId = 0;
        $("#selected-store-invoice-tab").text("All Stores");
        $("#selected-store-invoice-tab").data("id", 0);
        customerNameSearch = "";
        $("#date-range-picker").val("");
        startDate = null;
        endDate = null;
        $("#invoice-search-input").val(customerNameSearch);
        invoiceTable.ajax.reload();
    });

    initInvoiceTab();

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

    renderTable();

})(jQuery);