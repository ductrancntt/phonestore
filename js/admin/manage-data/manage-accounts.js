(function ($) {

    let accountTable = null;
    let searchName = "";
    let requestUrl = "/js/admin/manage-data/account.php";
    let accounts = [];
    let selectedId = null;

    let renderTable = function () {
        accountTable = $("#account-table").DataTable({
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
                    "search": searchName
                };
                $.get(requestUrl, params, function (response) {
                    accounts = response.data;
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
                        return data.username;
                    },
                    "targets": 1
                },
                {
                    "render": function (data) {
                        return data.email;
                    },
                    "targets": 2
                },
                {
                    "render": function (data) {
                        return data.name;
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
                        return data.phone;
                    },
                    "targets": 5
                },
                {
                    "render": function (data) {
                        if (data.is_admin === "1")
                            return "<td class='align-middle'><span class='badge badge-info'>Admin</span></td>";
                        else
                            return "<td class='align-middle'><span class='badge badge-info'>User</span></td>";
                    },
                    "targets": 6
                },
                {
                    "render": function (data) {
                        if (data.enable === "1")
                            return "<td class='align-middle'><span class='badge badge-success'>Activated</span></td>";
                        else
                            return "<td class='align-middle'><span class='badge badge-danger'>Deactivated</span></td>";
                    },
                    "targets": 7
                },
                {
                    "render": function (data) {
                        if (data.enable == "0"){
                            return "<div class='table-right-button'>" +
                                "<button type='button' class='btn btn-info btn-table-employee font-responsive' data-id='" + data.id + "' style='margin-right: 10px;' data-toggle='modal' data-target='#account-modal'>" +
                                "<i class='fas fa-pen'></i>" +
                                "</button>" +
                                "<button style='width: 40px;' type='button' class='btn btn-success btn-table-employee font-responsive' data-id='" + data.id + "' data-toggle='modal' data-target='#account-enable-modal'>" +
                                "<i class='fas fa-check'></i>" +
                                "</button>" +
                                "</div>";
                        }
                        return "<div class='table-right-button'>" +
                            "<button type='button' class='btn btn-info btn-table-employee font-responsive' data-id='" + data.id + "' style='margin-right: 10px;' data-toggle='modal' data-target='#account-modal'>" +
                            "<i class='fas fa-pen'></i>" +
                            "</button>" +
                            "<button style='width: 40px;' type='button' class='btn btn-danger btn-table-employee font-responsive' data-id='" + data.id + "' data-toggle='modal' data-target='#account-disable-modal'>" +
                            "<i class='fas fa-times'></i>" +
                            "</button>" +
                            "</div>";
                    },
                    "targets": 8
                }
            ],
            drawCallback: function () {
                $("button.btn.btn-info.btn-table-employee").click(function () {
                    for (let i = 0; i < accounts.length; i++) {
                        if (accounts[i].id == $(this).data("id")) {
                            fillModal(accounts[i]);
                            break;
                        }
                    }
                });
                $("button.btn.btn-danger.btn-table-employee").click(function () {
                    selectedId = $(this).data("id");
                });
                $("button.btn.btn-success.btn-table-employee").click(function () {
                    selectedId = $(this).data("id");
                });
            }
        });
    }

    function fillModal(data) {
        if (data == null) {
            $("#account-modal-title").text("Add Account");
            $("#status-selector-account-tab").val('1');
            $("#type-selector-account-tab").val('1');
            $("input[name='id']").val("");
            $("input[name='account-name']").val("");
            $("input[name='phone']").val("");
            $("input[name='address']").val("");
            $("input[name='username']").val("");
            $("input[name='password']").val("");
            $("input[name='phone']").val("");
            $("input[name='email']").val("");
            $("input[name='address']").val("");
        } else {
            $("#account-modal-title").text("Edit Account");
            $("#status-selector-account-tab").val(data.enable);
            $("#type-selector-account-tab").val(data.is_admin);
            $("input[name='id']").val(data.id);
            $("input[name='account-name']").val(data.name);
            $("input[name='phone']").val(data.phone);
            $("input[name='address']").val(data.address);
            $("input[name='username']").val(data.username);
            $("input[name='password']").val(data.password);
            $("input[name='phone']").val(data.phone);
            $("input[name='email']").val(data.email);
        }
    }

    function validateForm(data) {
        let valid = true;
        let message = "";
        if (data.name == "" ||
            data.username == "" ||
            data.password == ""
        ) {
            valid = false;
            message = "Please fill in all required(*) fields!";
        }
        return {
            valid: valid,
            message: message,
        }
    }

    $("#save-account").click(function () {
        let id = $("input[name='id']").val();
        let name = $("input[name='account-name']").val();
        let phone = $("input[name='phone']").val();
        let address = $("input[name='address']").val();
        let enable = $("#status-selector-account-tab").val();
        let isAdmin = $("#type-selector-account-tab").val();
        let username = $("input[name='username']").val();
        let password = $("input[name='password']").val();
        let email = $("input[name='email']").val();

        let account = {
            id: id,
            name: name,
            phone: phone,
            address: address,
            enable: enable,
            is_admin: isAdmin,
            username: username,
            password: password,
            email: email,
        }

        let check = validateForm(account);
        if (!check.valid){
            AlertService.error(check.message);
            return;
        }

        if (id == ""){
            account.create = "true";
        } else {
            account.update = "true";
        }

        $.post(requestUrl, account, function (response) {
            if (response.error == 0) {
                $("#account-modal").modal('hide');
                accountTable.ajax.reload(null, false);
                AlertService.success(response.message);
            } else {
                AlertService.error(response.message)
            }
        });

    });

    $("#disable-account").click(function () {
        let account = {
            toggle: "true",
            enable: "0",
            id: selectedId
        }

        $.post(requestUrl, account, function (response) {
            if (response.error == 0) {
                $("#account-disable-modal").modal('hide');
                accountTable.ajax.reload(null, false);
                AlertService.success(response.message);
            } else {
                AlertService.error(response.message)
            }
        });
    });

    $("#enable-account").click(function () {
        let account = {
            toggle: "true",
            enable: "1",
            id: selectedId
        }

        $.post(requestUrl, account, function (response) {
            if (response.error == 0) {
                $("#account-enable-modal").modal('hide');
                accountTable.ajax.reload(null, false);
                AlertService.success(response.message);
            } else {
                AlertService.error(response.message)
            }
        });
    });

    $("#add-account").click(function () {
        fillModal(null)
    });

    $("#search-account-button").click(function () {
        searchName = $("#account-search-input").val();
        accountTable.ajax.reload();
    });

    $("#account-refresh-button").click(function () {
        searchName = "";
        $("#account-search-input").val(searchName);
        accountTable.ajax.reload();
    });

    renderTable();

})(jQuery);