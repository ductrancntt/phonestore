(function ($) {

    let customerTable = null;
    let customerNameSearch = "";
    let customer = null;

    let loadCustomerInfo = function (id) {
        $.get("/api/customers/" + id, function (response) {
            customer = response;
            $("#status-selector-customer-tab").val(customer.user.enable + '');
        });
    }

    let renderTable = function () {
        customerTable = $("#customer-table").DataTable({
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
                    "customerName": customerNameSearch
                };
                $.get("/api/customers/page", params, function (response) {
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
                        if (data.user != null)
                            return data.user.username;
                        else
                            return "";
                    },
                    "targets": 1
                },
                {
                    "render": function (data) {
                        return data.customerName;
                    },
                    "targets": 2
                },
                {
                    "render": function (data) {
                        return data.phone;
                    },
                    "targets": 3
                },
                {
                    "render": function (data) {
                        return data.address;
                    },
                    "targets": 4
                },
                {
                    "render": function (data) {
                        if (data.online) {
                            return "<span class='badge badge-success'>Online</span>";
                        } else {
                            return "<span class='badge badge-secondary'>Offline</span>";
                        }
                    },
                    "targets": 5
                },
                {
                    "render": function (data) {
                        if (data.online) {
                            if (data.user.enable)
                                return "<td class='align-middle'><span class='badge badge-success'>Activated</span></td>";
                            else
                                return "<td class='align-middle'><span class='badge badge-danger'>Deactivated</span></td>";
                        } else {
                            return "";
                        }

                    },
                    "targets": 6
                },
                {
                    "render": function (data) {
                        if (data.online)
                            return "<div class='table-right-button'>" +
                                "<button type='button' class='btn btn-info btn-table-customer font-responsive' data-id='" + data.id + "' style='margin-right: 10px;' data-toggle='modal' data-target='#customer-modal'>" +
                                "<i class='fas fa-pen'></i>" +
                                "</button>" +
                                "</div>";
                        else
                            return "";
                    },
                    "targets": 7
                }
            ],
            drawCallback: function () {
                $("button.btn.btn-info.btn-table-customer").click(function () {
                    loadCustomerInfo($(this).data("id"));
                });
            }
        });
    }

    $("#save-customer").click(function () {
        customer.user.enable = ($("#status-selector-customer-tab").val() == 'true');

        $.ajax({
            type: "POST",
            url: "/api/customers/activation",
            data: JSON.stringify(customer),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function () {
                customerTable.ajax.reload();
            },
            error: function () {
                customerTable.ajax.reload();
            }
        });

        $("#customer-modal").modal('hide');
    });

    $("#search-customer-button").click(function () {
        customerNameSearch = $("#customer-search-input").val();
        customerTable.ajax.reload();
    });

    $("#customer-refresh-button").click(function () {
        customerNameSearch = "";
        $("#customer-search-input").val(customerNameSearch);
        customerTable.ajax.reload();
    });

    renderTable();

})(jQuery);