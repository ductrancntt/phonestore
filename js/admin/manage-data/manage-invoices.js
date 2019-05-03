(function ($) {
    let startDate = null;
    let endDate = null;
    let dataTable = null;
    let searchId = null;
    let requestUrl = "/js/admin/manage-data/invoice.php";
    let invoices = [];
    let selectedId = null;
    let users = [];

    let renderTable = function () {
        dataTable = $("#invoice-table").DataTable({
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
                    "search": searchId,
                    "startDate": startDate == null ? "" : (new Date(startDate)).getTime(),
                    "endDate": endDate == null ? "" : (new Date(endDate).getTime()) + 24 * 60 * 60
                };
                $.get(requestUrl, params, function (response) {
                    invoices = response.data;
                    users = response.users;
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
                        for (let i = 0; i < users.length; i++) {
                            if (users[i].id == data.user_id){
                                return users[i].username
                            }
                        }
                    },
                    "targets": 1
                },
                {
                    "render": function (data) {
                        return data.created_date;
                    },
                    "targets": 2
                },
                {
                    "render": function (data) {
                        return data.ship_address;
                    },
                    "targets": 3
                },
                {
                    "render": function (data) {
                        switch (parseInt(data.status)) {
                            case 0: {
                                return "<td class='align-middle'><span class='badge badge-info'>Ordered</span></td>";
                            }
                            case 1: {
                                return "<td class='align-middle'><span class='badge badge-warning'>Delivering</span></td>";
                            }
                            case 2: {
                                return "<td class='align-middle'><span class='badge badge-success'>Delivered</span></td>";
                            }
                            case 3: {
                                return "<td class='align-middle'><span class='badge badge-danger'>Cancelled</span></td>";
                            }
                            default: {
                                return "<td class='align-middle'><span class='badge badge-info'>N/A</span></td>";
                            }
                        }

                    },
                    "targets": 4
                },
                {
                    "render": function (data) {
                        return formatNumber(data.total) + " ₫";
                    },
                    "targets": 5
                },
                {
                    "render": function (data) {
                        if (data.status == 2 || data.status == 3) return "";
                        return "<div class='table-right-button'>" +
                            "<button type='button' class='btn btn-info btn-table-invoice font-responsive' data-id='" + data.id + "' style='margin-right: 10px;' data-toggle='modal' data-target='#invoice-update-modal'>" +
                            "<i class='fas fa-pen'></i>" +
                            "</button>" +
                            "</div>";
                    },
                    "targets": 6
                }
            ],
            drawCallback: function () {
                $("button.btn.btn-info.btn-table-invoice").click(function () {
                    selectedId = $(this).attr("data-id");
                    console.log(selectedId);
                });
                $("button.btn.btn-danger.btn-table-invoice").click(function () {

                });
            }
        });
    }

    let dateRange = $("#date-range-picker");

    dateRange.daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    dateRange.on('apply.daterangepicker', function (ev, picker) {
        startDate = picker.startDate.format('DD/MM/YYYY');
        endDate = picker.endDate.format('DD/MM/YYYY');
        $(this).val(startDate + ' ~ ' + endDate);
    });

    dateRange.on('cancel.daterangepicker', function (ev, picker) {
        startDate = null;
        endDate = null;
        $(this).val('');
    });

    $("#analyze-button").click(function () {
        dataTable.ajax.reload();
    });

    $("#search-invoice-button").click(function () {
        searchId = $("#invoice-search-input").val();
        dataTable.ajax.reload();
    });
    $("#update-invoice-btn").click(function () {
        let status = $("#invoice-status").val();
        let params = {
            save: "save",
            id: selectedId,
            status: status
        }
        $.post(requestUrl, params, function (response) {
            if (response.error == "0"){
                AlertService.success(response.message);
                $("#invoice-update-modal").modal('hide');
                dataTable.ajax.reload(null, false);
            } else {
                AlertService.error(response.message);
            }
        })
    });

    renderTable();

    $("#export-button").unbind('click');
    $("#export-button").click(function () {
        let titleRow = ["ID","Created Date","Username", "Ship Address", "Status", "Total"];
        let BOM = "\uFEFF";
        let csvContent = "data:text/csv;charset=utf-8,";
        csvContent += BOM;
        csvContent += titleRow + "\n";
        invoices.forEach(e => {
            let row = [];
            row.push(e.id);
            row.push(e.created_date);

            for (let i = 0; i < users.length; i++) {
                if (users[i].id == e.user_id){
                    row.push(users[i].username);
                }
            }
            let add = e.ship_address.split(",");
            let address = "";
            add.forEach(e => {
                address += e + " - ";
            })
            row.push(address);
            switch (parseInt(e.status)) {
                case 0: {
                    row.push("Ordered");
                    break;
                }
                case 1: {
                    row.push("Delivering");
                    break;
                }
                case 2: {
                    row.push("Delivered");
                    break;
                }
                case 3: {
                    row.push("Canceled");
                    break;
                }
            }

            row.push(e.total);
            csvContent += row + "\n";
        })

        let downloadLink = document.createElement("a");
        downloadLink.href = csvContent;
        downloadLink.download = "export.csv";
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);


    })
})(jQuery);