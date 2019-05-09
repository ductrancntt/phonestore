(function ($) {
        let image = null;
        let selectedId = null;
        let banners = [];
        let dataTable = null;
        let bannerUrl = "/js/admin/manage-data/banner.php";

        renderTable();

        function renderTable() {
            dataTable = $("#banner-table").DataTable({
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
                    };
                    $.get(bannerUrl, params, function (response) {
                        banners = response.data;
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
                            return "<img src='" + data.image + "' style='width: 400px; height: 200px'/>";
                        },
                        "targets": 1
                    },
                    {
                        "render": function (data) {
                            if (data.enable === "1")
                                return "<td class='align-middle'><span class='badge badge-success'>Enable</span></td>";
                            else
                                return "<td class='align-middle'><span class='badge badge-danger'>Disable</span></td>";
                        },
                        "targets": 2
                    },
                    {
                        "render": function (data) {
                            return "<div class='table-right-button'>" +
                                "<button type='button' class='btn btn-info btn-table-manufacturer font-responsive' data-id='" + data.id + "' style='margin-right: 10px;' data-toggle='modal' data-target='#banner-modal'>" +
                                "<i class='fas fa-pen'></i>" +
                                "</button>" +
                                "<button type='button' class='btn btn-danger btn-table-manufacturer font-responsive' data-id='" + data.id + "' data-toggle='modal' data-target='#banner-delete-modal'>" +
                                "<i class='fas fa-times'></i>" +
                                "</button>" +
                                "</div>";
                        },
                        "targets": 3
                    }
                ],
                drawCallback: function () {
                    $("button.btn.btn-info.btn-table-manufacturer").click(function () {
                        for (let i = 0; i < banners.length; i++) {
                            if (banners[i].id == $(this).attr("data-id")) {
                                fillModal(banners[i]);
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
                $("#banner-modal-title").text("Edit Banner");
                $("input[name='banner-id']").val(entity.id);
                $("#banner-status").val(entity.enable);
            } else {
                $("#banner-modal-title").text("Add Banner");
                $("input[name='banner-id']").val("");
                $("#banner-status").val("1")
            }
        }

        $("#add-banner").click(function () {
            fillModal(null);
        })

        $("#save-banner").click(function () {
            let data = {
                id: $("input[name='banner-id']").val(),
                enable: $("#banner-status").val(),
            }

            let formData = new FormData();
            formData.append("save", "save");
            formData.append("image", image);
            formData.append("entity", JSON.stringify(data));

            $.ajax({
                type: "POST",
                url: bannerUrl,
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.error == 0) {
                        $("#banner-modal").modal('hide');
                        dataTable.ajax.reload(null, false);
                        AlertService.success(response.message)
                    } else {
                        AlertService.error(response.message)
                    }
                }
            });
        });

        $("#delete-banner").click(function () {
            let formData = new FormData();
            formData.append("delete", "delete");
            formData.append("id", selectedId);
            $.ajax({
                type: "POST",
                url: bannerUrl,
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.error == 0) {
                        $("#banner-delete-modal").modal("hide");
                        dataTable.ajax.reload(null, false);
                        AlertService.success(response.message)
                    } else {
                        AlertService.error(response.message)
                    }
                }
            })
        });

        $("#image-input").change(function () {
            image = this.files[0];
            let fileName = $(this).val().split("\\").pop();
            if (fileName.length > 30){
                fileName = fileName.substring(0,20) + '...';
            }
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        $("#change-time-button").click(function () {
            let time = $("#banner-time").val();
            if (time <= 0){
                AlertService.error("Time must greater than 0!");
                return;
            }
            let params = {
                changeTime: "changeTime",
                time: time
            }
            $.post(bannerUrl, params, function (response) {
                if (response.error == "0"){
                    AlertService.success(response.message);
                    $("#banner-time").val("");
                    getBannerTime();
                } else {
                    AlertService.error(response.message);
                }
            })
        });

        getBannerTime();
        function getBannerTime() {
            let params = {
                getTime: "getTime",
            }
            $.get(bannerUrl, params, function (response) {
                console.log(response);
                $("#current-time").val(response.data.value + "(ms)");
            })
        }

    }
)(jQuery);