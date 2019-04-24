(function ($) {

    let manufacturer = null;
    let manufacturerTable = null;
    let manufacturerNameSearch = "";
    let image = null;

    let loadManufacturerInfo = function (id) {
        $.get("/api/manufacturers/" + id, function (response) {
            manufacturer = response;
            $("#manufacturer-modal-title").text("Edit Manufacturer");
            $("input[name='manufacturer-name']").val(manufacturer.manufacturerName);
            $("textarea[name='manufacturer-description']").val(manufacturer.description);
        });
    }

    let renderTable = function () {
        manufacturerTable = $("#manufacturer-table").DataTable({
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
                    "manufacturerName": manufacturerNameSearch
                };
                $.get("/api/manufacturers/page", params, function (response) {
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
                        return data.manufacturerName;
                    },
                    "targets": 1
                },
                {
                    "render": function (data) {
                        return "<img src='" + data.url + "' style='max-width: 6vw'/>";
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
                        return "<div class='table-right-button'>" +
                            "<button type='button' class='btn btn-info btn-table-manufacturer font-responsive' data-id='" + data.id + "' style='margin-right: 10px;' data-toggle='modal' data-target='#manufacturer-modal'>" +
                            "<i class='fas fa-pen'></i>" +
                            "</button>" +
                            "<button type='button' class='btn btn-danger btn-table-manufacturer font-responsive' data-id='" + data.id + "'>" +
                            "<i class='fas fa-times'></i>" +
                            "</button>" +
                            "</div>";
                    },
                    "targets": 4
                }
            ],
            drawCallback: function () {
                $("button.btn.btn-info.btn-table-manufacturer").click(function () {
                    $("#manufacturer-modal-title").text("Edit Manufacturer");
                    loadManufacturerInfo($(this).data("id"));
                });
                $("button.btn.btn-danger.btn-table-manufacturer").click(function () {
                    let id = $(this).data("id");
                    $.get("/api/manufacturers/associated/" + id, function (response) {
                        if (response == true) {
                            // $("#alert-message").html("You <strong>CAN NOT DELETE</strong> this manufacturer, because it is <strong>ASSOCIATED</strong>!");
                        } else {
                            $.get("/api/manufacturers/" + id, function (response) {
                                manufacturer = response;
                                $("#manufacturer-delete-modal").modal("show");
                            });
                        }
                    });
                });
            }
        });
    }

    $("#save-manufacturer").click(function () {
        let manufacturerName = $("input[name='manufacturer-name']").val();
        let description = $("textarea[name='manufacturer-description']").val();

        if (manufacturer == null) {
            manufacturer = {
                id: null,
                manufacturerName: manufacturerName,
                description: description,
                url: '/image/no_image.png'
            }
        } else {
            manufacturer.manufacturerName = manufacturerName;
            manufacturer.description = description;
        }

        let formData = new FormData();
        formData.append("image", image);
        formData.append("manufacturer", new Blob([JSON.stringify(manufacturer)], {type: "application/json"}));

        $.ajax({
            type: "POST",
            url: "/api/manufacturers",
            data: formData,
            contentType: false,
            processData: false,
            success: function () {
                manufacturerTable.ajax.reload();
            },
            error: function () {
                manufacturerTable.ajax.reload();
            }
        });

        $("#manufacturer-modal").modal('hide');
    });

    $("#delete-manufacturer").click(function () {
        $.post("/api/manufacturers/delete/" + manufacturer.id, function () {
            manufacturerTable.ajax.reload();
        });

        $("#manufacturer-delete-modal").modal("hide");
    });

    $("button[data-target='#manufacturer-modal']").click(function () {
        manufacturer = null;
        $("#manufacturer-modal-title").text("Add Manufacturer");
        $("input[name='manufacturer-name']").val("");
        $("textarea[name='manufacturer-description']").val("");
    });

    $("#search-manufacturer-button").click(function () {
        manufacturerNameSearch = $("#manufacturer-search-input").val();
        manufacturerTable.ajax.reload();
    });

    $("#manufacturer-refresh-button").click(function () {
        manufacturerNameSearch = "";
        $("#manufacturer-search-input").val(manufacturerNameSearch);
        manufacturerTable.ajax.reload();
    });

    $("#image-input").change(function () {
        image = this.files[0];
    });

    renderTable();

})(jQuery);