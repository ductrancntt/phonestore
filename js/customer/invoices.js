(function ($) {

    let startDate = null;
    let endDate = null;
    let selectedStoreId = 0;
    let table = null;
    let invoiceDetail = null;

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

    let loadInvoiceDetail = function (id) {
        $.get("/api/customers/invoice-detail", {invoiceId: parseInt(id)}, function (response) {
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

    let loadInvoices = function() {
        $.get("./service/loadInvoices.php", {startDate: startDate, endDate: endDate}, function (response) {
            renderTable(response);
        });
    }

    let renderTable = function (data) {
        $("#invoice-table tbody").empty();
        data.forEach(function (e) {
            let row = "<tr>";

            row += "</tr>";
            $("#invoice-table tbody").append(row);
        });
        // table = $("#invoice-table").DataTable({
        //     "pageLength": 10,
        //     "lengthMenu": [[10, 20, 30], [10, 20, 30]],
        //     "scrollX": false,
        //     "serverSide": true,
        //     "ordering": false,
        //     "bFilter": false,
        //     "language": {
        //         "oPaginate": {
        //             sNext: "<i class='fas fa-angle-right'></i>",
        //             sPrevious: "<i class='fas fa-angle-left'></i>"
        //         }
        //     },
        //     "ajax": function (requestParams, render) {
        //         let params = {
        //             "page": (requestParams.start / requestParams.length) + 1,
        //             "limit": requestParams.length,
        //             "storeId": selectedStoreId,
        //             "startDate": startDate,
        //             "endDate": endDate
        //         };
        //
        //         $.get("/api/invoices/customer/page", params, function (response) {
        //             render({
        //                 "draw": requestParams.draw,
        //                 "recordsTotal": response.totalElements,
        //                 "recordsFiltered": response.totalElements,
        //                 "data": response.content
        //             });
        //         });
        //     },
        //     "columns": [
        //         {
        //             "data": null,
        //             "className": 'align-middle bold font-responsive'
        //         },
        //         {
        //             "data": null,
        //             "className": 'align-middle font-responsive'
        //         },
        //         {
        //             "data": null,
        //             "className": 'align-middle font-responsive'
        //         },
        //         {
        //             "data": null,
        //             "className": 'align-middle font-responsive'
        //         },
        //         {
        //             "data": null,
        //             "className": 'align-middle font-responsive'
        //         },
        //         {
        //             "data": null,
        //             "className": 'align-middle'
        //         }
        //     ],
        //     "columnDefs": [
        //         {
        //             "render": function (data) {
        //                 return data.id;
        //             },
        //             "targets": 0
        //         },
        //         {
        //             "render": function (data) {
        //                 return data.customer.customerName;
        //             },
        //             "targets": 1
        //         },
        //         {
        //             "render": function (data) {
        //                 return formatNumber(data.total) + " ₫";
        //             },
        //             "targets": 2
        //         },
        //         {
        //             "render": function (data) {
        //                 return data.store.storeName;
        //             },
        //             "targets": 3
        //         },
        //         {
        //             "render": function (data) {
        //                 return data.createdDate;
        //             },
        //             "targets": 4
        //         },
        //         {
        //             "render": function (data) {
        //                 return "<div class='table-right-button'>" +
        //                     "<button type='button' class='btn btn-info btn-table-invoice font-responsive' data-id='" + data.id + "' style='margin-right: 10px;' data-toggle='modal' data-target='#invoice-modal'>" +
        //                     "<i class='fas fa-eye'></i>" +
        //                     "</button>" +
        //                     "</div>";
        //             },
        //             "targets": 5
        //         }
        //     ],
        //     drawCallback: function () {
        //         $("button.btn.btn-info.btn-table-invoice").click(function () {
        //             loadInvoiceDetail($(this).data("id"));
        //         });
        //     }
        // });
    }

    $("#search-invoice-button").click(function () {
        selectedStoreId = parseInt($("#selected-store").data("id"));
        table.ajax.reload();
    });

    $("#invoice-refresh-button").click(function () {
        selectedStoreId = 0;
        $("#selected-store").text("All Stores");
        $("#selected-store").data("id", 0);
        $("#date-range-picker").val("");
        startDate = null;
        endDate = null;
        table.ajax.reload();
    });

    loadInvoices();

})(jQuery);