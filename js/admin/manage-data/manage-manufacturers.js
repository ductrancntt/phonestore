(function ($) {
        let image = null;
        let selectedId = null;
        let manufacturers = [];
        let dataTable = null;
        let manufacturerUrl = "/js/admin/manage-data/manufacturer.php";
        let searchName = "";

        renderTable();

        function renderTable() {
            dataTable = $("#manufacturer-table").DataTable({
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
                    },
                },
                "ajax": function (requestParams, render) {
                    let params = {
                        "getAll": "getAll",
                        "page": (requestParams.start / requestParams.length) + 1,
                        "limit": requestParams.length,
                        "search": searchName
                    };
                    $.get(manufacturerUrl, params, function (response) {
                        manufacturers = response.data;
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
                        "className": 'align-middle'
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
                            return data.name;
                        },
                        "targets": 1
                    },
                    {
                        "render": function (data) {
                            return "<img src='" + data.image + "' style='max-width: 6vw'/>";
                        },
                        "targets": 2
                    },
                    {
                        "render": function (data) {
                            return data.address;
                        },
                        "targets": 3
                    },
                    {
                        "render": function (data) {
                            return "<div class='table-right-button'>" +
                                "<button type='button' class='btn btn-info btn-table-manufacturer font-responsive' data-id='" + data.id + "' style='margin-right: 10px;' data-toggle='modal' data-target='#manufacturer-modal'>" +
                                "<i class='fas fa-pen'></i>" +
                                "</button>" +
                                "<button type='button' class='btn btn-danger btn-table-manufacturer font-responsive' data-id='" + data.id + "' data-toggle='modal' data-target='#manufacturer-delete-modal'>" +
                                "<i class='fas fa-times'></i>" +
                                "</button>" +
                                "</div>";
                        },
                        "targets": 4
                    }
                ],
                drawCallback: function () {
                    $("button.btn.btn-info.btn-table-manufacturer").click(function () {
                        for (let i = 0; i < manufacturers.length; i++) {
                            if (manufacturers[i].id == $(this).attr("data-id")) {
                                fillModal(manufacturers[i]);
                                break;
                            }
                        }
                    });
                    $("button.btn.btn-danger.btn-table-manufacturer").click(function () {
                        selectedId = $(this).attr("data-id");
                    });
                }
            });
        }

        function fillModal(entity) {
            image = null;
            if (entity != null) {
                $("#manufacturer-modal-title").text("Edit Manufacturer");
                $("input[name='manufacturer-id']").val(entity.id);
                $("input[name='manufacturer-name']").val(entity.name);
                $("textarea[name='manufacturer-address']").val(entity.address);
            } else {
                $("#manufacturer-modal-title").text("Add Manufacturer");
                $("input[name='manufacturer-id']").val("");
                $("input[name='manufacturer-name']").val("");
                $("textarea[name='manufacturer-address']").val("");
            }
        }

        $("#add-manufacturer").click(function () {
            fillModal(null);
        })

        function validateForm(data) {
            let valid = true;
            let message = "";
            if (data.name == "" ||
                data.address == ""
            ) {
                valid = false;
                message = "Please fill in all required(*) fields!";
            }
            return {
                valid: valid,
                message: message,
            }
        }

        $("#save-manufacturer").click(function () {
            let data = {
                id: $("input[name='manufacturer-id']").val(),
                name: $("input[name='manufacturer-name']").val(),
                address: $("textarea[name='manufacturer-address']").val()
            }

            let check = validateForm(data);
            if (!check.valid){
                alert(check.message);
                return;
            }

            let formData = new FormData();
            formData.append("save", "save");
            formData.append("image", image);
            formData.append("entity", JSON.stringify(data));

            $.ajax({
                type: "POST",
                url: manufacturerUrl,
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.error == 0) {
                        $("#manufacturer-modal").modal('hide');
                        dataTable.ajax.reload(null, false);
                    } else {
                        alert(response.message)
                    }
                }
            });
        });

        $("#delete-manufacturer").click(function () {
            let formData = new FormData();
            formData.append("delete", "delete");
            formData.append("id", selectedId);
            $.ajax({
                type: "POST",
                url: manufacturerUrl,
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.error == 0) {
                        $("#manufacturer-delete-modal").modal("hide");
                        dataTable.ajax.reload(null, false);
                    } else {
                        alert(response.message);
                    }
                }
            })
        });

        $("#search-manufacturer-button").click(function () {
            searchName = ($("#manufacturer-search-input").val());
            dataTable.ajax.reload();
        });

        $("#manufacturer-refresh-button").click(function () {
            searchName = "";
            $("#manufacturer-search-input").val(searchName);
            dataTable.ajax.reload();
        });

        $("#image-input").change(function () {
            image = this.files[0];
        });

    }
)(jQuery);