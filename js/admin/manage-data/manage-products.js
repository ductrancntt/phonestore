(function ($) {
    $(document).ready(function () {
        CKEDITOR.config.height = 100;
        CKEDITOR.replace('product-description');
    })

    let manufacturerList = [];
    let productTable = null;
    let searchName = "";
    let image = null;
    let products = [];

    let productUrl = "/js/admin/manage-data/product.php";
    let manufacturerUrl = "/js/admin/manage-data/manufacturer.php";

    let selectedId = null;

    let loadManufacturers = function () {
        $.get(manufacturerUrl, {getAll: "getAll", limit: 0, page: 1, search: ""}, function (response) {
            manufacturerList = response.data;
            $("#manufacturer-selector").empty();
            manufacturerList.forEach(function (manufacturer) {
                $("#manufacturer-selector").append("<option value='" + manufacturer.id + "'>" + manufacturer.name + "</option>");
            });
        });
    }

    let renderTable = function () {
        productTable = $("#product-table").DataTable({
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
                    "search": searchName
                };
                $.get(productUrl, params, function (response) {
                    products = response.data;
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
                        return "<a target='_blank' href='./product-detail.php?id=" + data.id + "'>" + data.name + "</a>";
                    },
                    "targets": 1
                },
                {
                    "render": function (data) {
                        return formatNumber(data.price) + " ₫";

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
                        return data.screen_size + " inch";
                    },
                    "targets": 4
                },
                {
                    "render": function (data) {
                        return data.memory;
                    },
                    "targets": 5
                },
                {
                    "render": function (data) {
                        return data.chipset;
                    },
                    "targets": 6
                },
                {
                    "render": function (data) {
                        return "<img src='" + data.image + "' style='max-width: 5vw'/>";
                    },
                    "targets": 7
                },
                {
                    "render": function (data) {
                        let manu = {};
                        for (let i = 0; i < manufacturerList.length; i++) {
                            if (manufacturerList[i].id == data.manufacturer_id) {
                                manu = manufacturerList[i];
                                break;
                            }
                        }
                        if (manu.name) {
                            return manu.name;
                        }
                        return "N/A";

                    },
                    "targets": 8
                },
                {
                    "render": function (data) {
                        return data.quantity + " pcs";
                    },
                    "targets": 9
                },
                {
                    "render": function (data) {
                        return "<div class='table-right-button'>" +
                            "<button style='min-width: 40px; margin: 2px' type='button' class='btn btn-info btn-table-product font-responsive' data-id='" + data.id + "' style='margin-right: 10px;' data-toggle='modal' data-target='#product-modal'>" +
                            "<i class='fas fa-pen'></i>" +
                            "</button>" +
                            "<button style='min-width: 40px; margin: 2px' type='button' class='btn btn-danger btn-table-product font-responsive' data-id='" + data.id + "' data-toggle='modal' data-target='#product-delete-modal'>" +
                            "<i class='fas fa-times'></i>" +
                            "</button>" +
                            "</div>";
                    },
                    "targets": 10
                }
            ],
            drawCallback: function () {
                $("button.btn.btn-info.btn-table-product").click(function () {
                    for (let i = 0; i < products.length; i++) {
                        if (products[i].id == $(this).attr("data-id")) {
                            fillModal(products[i]);
                            break;
                        }
                    }
                });
                $("button.btn.btn-danger.btn-table-product").click(function () {
                    selectedId = $(this).attr("data-id");
                });
            }
        });
    }

    function fillModal(data) {
        image = null;
        if (data == null) {
            $("#product-modal-title").text("Add Product");
            $("input[name='id']").val("");
            $("input[name='product-name']").val("");
            $("input[name='price']").val("100000");
            CKEDITOR.instances['product-description'].setData("");
            $("input[name='screen-size']").val("3.0");
            $("input[name='memory']").val("");
            $("input[name='chipset']").val("");
            $("#manufacturer-selector").val();
            $("input[name='quantity']").val(0);
        } else {
            $("#product-modal-title").text("Edit Product");
            $("input[name='id']").val(data.id);
            $("input[name='product-name']").val(data.name);
            $("input[name='price']").val(data.price);
            CKEDITOR.instances['product-description'].setData(data.description);
            $("input[name='screen-size']").val(data.screen_size);
            $("input[name='memory']").val(data.memory);
            $("input[name='chipset']").val(data.chipset);
            $("#manufacturer-selector").val(data.manufacturer_id);
            $("input[name='quantity']").val(data.quantity);
        }
    }

    function validateForm(data) {
        let valid = true;
        let message = "";
        if (data.name == "" ||
            data.price == "" ||
            data.description == "" ||
            data.screen_size == "" ||
            data.memory == "" ||
            data.chipset == "" ||
            data.manufacturer_id == "" ||
            data.quantity == ""
        ) {
            return {
                valid: false,
                message: "Please fill in all required(*) fields!",
            }
        }

        if (data.price <= 0){
            return {
                valid: false,
                message: "Price must greater than 0",
            }
        }

        if (data.quantity <= 0){
            return {
                valid: false,
                message: "Quantity must greater than 0",
            }
        }

        if (data.screen_size <= 0){
            return {
                valid: false,
                message: "Screen size must greater than 0",
            }
        }

        return {
            valid: valid,
            message: message,
        }
    }

    $("#save-product").click(function () {
        let id = $("input[name='id']").val();
        let name = $("input[name='product-name']").val();
        let price = $("input[name='price']").val();
        let description = CKEDITOR.instances['product-description'].getData();
        let screen_size = $("input[name='screen-size']").val();
        let memory = $("input[name='memory']").val();
        let chipset = $("input[name='chipset']").val();
        let manufacturer_id = $("#manufacturer-selector").val();
        let quantity = $("input[name='quantity']").val();

        let product = {
            id: id,
            name: name,
            price: price,
            description: description,
            screen_size: screen_size,
            memory: memory,
            chipset: chipset,
            manufacturer_id: manufacturer_id,
            quantity: quantity,
            image: null,
        }

        let check = validateForm(product);
        if (!check.valid) {
            AlertService.error(check.message)
            return;
        }

        let formData = new FormData();
        formData.append("save", "save");
        formData.append("image", image);
        formData.append('product', JSON.stringify(product));

        // for (let prop in product) {
        //     if (product.hasOwnProperty(prop)) {
        //         formData.append('file-data[' + prop + ']', product[prop]);
        //     }
        // }

        $.ajax({
            type: "POST",
            url: productUrl,
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'JSON',
            success: function (response) {
                if (response.error == 0) {
                    $("#product-modal").modal('hide');
                    productTable.ajax.reload(null, false);
                    AlertService.success(response.message)
                } else {
                    AlertService.error(response.message)
                }
            },
            error: function () {
            }
        })

    });

    $("#delete-product").click(function () {
        let params = {
            delete: 'delete',
            id: selectedId
        };
        $.post(productUrl, params, function (response) {
            if (response.error == 0) {
                $("#product-delete-modal").modal('hide');
                productTable.ajax.reload(null, false);
                AlertService.success(response.message)
            } else {
                AlertService.error(response.message)
            }
        });

    });

    $("#add-product").click(function () {
        fillModal(null);
    })

    $("#search-product-button").click(function () {
        searchName = $("#product-search-input").val();
        productTable.ajax.reload();
    });

    $("#product-refresh-button").click(function () {
        searchName = "";
        $("#product-search-input").val(searchName);
        productTable.ajax.reload();
    });

    $("#image-input").change(function () {
        image = this.files[0];
        let fileName = $(this).val().split("\\").pop();
        if (fileName.length > 30) {
            fileName = fileName.substring(0, 20) + '...';
        }
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    loadManufacturers();

    renderTable();

})(jQuery);