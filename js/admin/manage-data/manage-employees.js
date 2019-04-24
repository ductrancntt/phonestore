(function ($) {

    let employeeTable = null;
    let employee = null;
    let employeeNameSearch = "";
    let selectedStoreId = 0;

    let loadEmployeeInfo = function (id) {
        $.get("/api/employees/" + id, function (response) {
            employee = response;
            $("#store-selector-employee-tab").val(employee.store.id);
            $("input[name='employee-name']").val(employee.employeeName);
            $("input[name='phone']").val(employee.phone);
            $("input[name='address']").val(employee.address);
            $("#status-selector-employee-tab").val(employee.user.enable + '');
        });
    }

    let renderTable = function () {
        employeeTable = $("#employee-table").DataTable({
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
                    "employeeName": employeeNameSearch
                };
                $.get("/api/employees/page", params, function (response) {
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
                        return data.user.username;
                    },
                    "targets": 1
                },
                {
                    "render": function (data) {
                        return data.store.storeName;
                    },
                    "targets": 2
                },
                {
                    "render": function (data) {
                        return data.employeeName;
                    },
                    "targets": 3
                },
                {
                    "render": function (data) {
                        return data.phone;
                    },
                    "targets": 4
                },
                {
                    "render": function (data) {
                        return data.address;
                    },
                    "targets": 5
                },
                {
                    "render": function (data) {
                        if (data.user.enable)
                            return "<td class='align-middle'><span class='badge badge-success'>Activated</span></td>";
                        else
                            return "<td class='align-middle'><span class='badge badge-danger'>Deactivated</span></td>";
                    },
                    "targets": 6
                },
                {
                    "render": function (data) {
                        return "<div class='table-right-button'>" +
                            "<button type='button' class='btn btn-info btn-table-employee font-responsive' data-id='" + data.id + "' style='margin-right: 10px;' data-toggle='modal' data-target='#employee-modal'>" +
                            "<i class='fas fa-pen'></i>" +
                            "</button>" +
                            "<button type='button' class='btn btn-danger btn-table-employee font-responsive' data-id='" + data.id + "' data-toggle='modal' data-target='#employee-disable-modal'>" +
                            "<i class='fas fa-times'></i>" +
                            "</button>" +
                            "</div>";
                    },
                    "targets": 7
                }
            ],
            drawCallback: function () {
                $("button.btn.btn-info.btn-table-employee").click(function () {
                    $("#employee-modal-title").text("Edit Employee");
                    $("#account-field").hide();
                    $("#store-selector-employee-tab").empty();
                    stores.forEach(function (store) {
                        $("#store-selector-employee-tab").append("<option value='" + store.id + "'>" + store.storeName + "</option>");
                    });
                    loadEmployeeInfo($(this).data("id"));
                });
                $("button.btn.btn-danger.btn-table-employee").click(function () {
                    $.get("/api/employees/" + $(this).data("id"), function (response) {
                        employee = response;
                    });
                });
            }
        });
    }

    $("#save-employee").click(function () {
        let employeeName = $("input[name='employee-name']").val();
        let phone = $("input[name='phone']").val();
        let address = $("input[name='address']").val();
        let enable = $("#status-selector-employee-tab").val() == 'true';
        let store_id = $("#store-selector-employee-tab").val();

        if (employee == null) {
            let username = $("input[name='username']").val();
            let password = $("input[name='password']").val();
            employee = {
                id: null,
                employeeName: employeeName,
                phone: phone,
                address: address,
                store: {
                    id: store_id,
                    location: null,
                    phone: null,
                    storeName: null
                },
                user: {
                    id: null,
                    username: username,
                    password: password,
                    enable: enable,
                    role: null
                }
            }
        } else {
            employee.employeeName = employeeName;
            employee.phone = phone;
            employee.address = address;
            employee.user.enable = enable;
        }

        $.ajax({
            type: "POST",
            url: "/api/employees",
            data: JSON.stringify(employee),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function () {
                employeeTable.ajax.reload();
            },
            error: function () {
                employeeTable.ajax.reload();
            }
        });

        $("#employee-modal").modal('hide');
    });

    $("#disable-employee").click(function () {
        employee.user.enable = false;

        $.ajax({
            type: "POST",
            url: "/api/employees",
            data: JSON.stringify(employee),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function () {
                employeeTable.ajax.reload();
            },
            error: function () {
                employeeTable.ajax.reload();
            }
        });

        $("#employee-disable-modal").modal('hide');
    });

    $("button[data-target='#employee-modal']").click(function () {
        employee = null;
        $("#employee-modal-title").text("Add Employee");
        $("#account-field").show();
        $("#store-selector-employee-tab").empty();
        stores.forEach(function (store) {
            $("#store-selector-employee-tab").append("<option value='" + store.id + "'>" + store.storeName + "</option>");
        });
        $("#status-selector-employee-tab").val('true');
        $("input[name='employee-name']").val("");
        $("input[name='phone']").val("");
        $("input[name='address']").val("");
        $("input[name='username']").val("");
        $("input[name='password']").val("");
        $("input[name='confirm-password']").val("");
    });

    let initEmployeeTab = function () {
        $("#stores-employee-tab").append("<a class='dropdown-item' href='#' data-id='0'>All Stores</a>");
        stores.forEach(function (store) {
            $("#stores-employee-tab").append("<a class='dropdown-item' href='#' data-id='" + store.id + "'>" + store.storeName + "</a>");
        });

        $("#stores-employee-tab a.dropdown-item").click(function () {
            $("#selected-store-employee-tab").text($(this).text());
            $("#selected-store-employee-tab").data("id", $(this).data("id"));
        });
    }

    $("#search-employee-button").click(function () {
        selectedStoreId = parseInt($("#selected-store-employee-tab").data("id"));
        employeeNameSearch = $("#employee-search-input").val();
        employeeTable.ajax.reload();
    });

    $("#employee-refresh-button").click(function () {
        selectedStoreId = 0;
        $("#selected-store-employee-tab").text("All Stores");
        $("#selected-store-employee-tab").data("id", 0);
        employeeNameSearch = "";
        $("#employee-search-input").val(employeeNameSearch);
        employeeTable.ajax.reload();
    });

    initEmployeeTab();

    renderTable();

})(jQuery);