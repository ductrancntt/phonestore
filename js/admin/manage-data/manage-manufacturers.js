(function ($) {
    let image = null;
    let selectId = null;
    let manufacturers = [];

    getAll();

    function getAll() {
        $.ajax({
            type: "GET",
            url: "js/admin/manage-data/manufacturer.php",
            dataType: 'JSON',
            data: {
                getAll: "getAll",
            },
            success: function (res) {
                renderTable(res);
            }
        })
    }

    function search(keyword) {
        let formData = new FormData();
        formData.append("search", keyword);
        $.ajax({
            type: "POST",
            url: "js/admin/manage-data/manufacturer.php",
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                renderTable(res);
            }
        })
    }

    function save(data) {
        $.ajax({
            type: "POST",
            url: "js/admin/manage-data/manufacturer.php",
            data: data,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.error){
                    alert(response.error);
                }else {
                    $("#manufacturer-modal").modal('hide');
                    getAll();
                }
            },
            error: function () {
                $("#manufacturer-modal").modal('hide');
            }
        });
    }

    function renderTable(data) {
        manufacturers = data;
        $("#manufacturer-table tbody").empty();
        data.forEach(function (e) {
            let row = "<tr>";
            row += "<td>" + e.id + "</td>";
            row += "<td>" + e.name + "</td>";
            row += "<td><img src='" + e.image + "' style='border: 2px dashed #bbb;width: 200px; height: 80px; object-fit: cover'></td>";
            row += "<td>" + e.address + "</td>";
            row += "<td>";
            row += "<div class='table-right-button'>" +
                "<button type='button' class='btn edit-btn btn-info btn-table-manufacturer font-responsive' data-id='" + e.id + "' style='margin-right: 10px;' data-toggle='modal' data-target='#manufacturer-modal'>" +
                "<i class='fas fa-pen'></i>" +
                "</button>" +
                "<button type='button' class='btn delete-btn btn-danger btn-table-manufacturer font-responsive' data-id='" + e.id + "' data-toggle='modal' data-target='#manufacturer-delete-modal'>" +
                "<i class='fas fa-times'></i>";
            row += "</td></tr>";
            $("#manufacturer-table tbody").append(row);
        });

        $("button.delete-btn").on('click', function () {
            selectId = $(this).attr("data-id");
        });

        $("button.edit-btn").on('click', function () {
            let id = $(this).attr("data-id");
            for (let i = 0; i < data.length; i++){
                if (manufacturers[i].id == id){
                    fillModal(manufacturers[i]);
                    break;
                }
            }
        });
    }

    function deleteManufacturer(id) {
        let formData = new FormData();
        formData.append("deleteId", id);
        $.ajax({
            type: "POST",
            url: "js/admin/manage-data/manufacturer.php",
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'JSON',
            success: function (res) {
                $("#manufacturer-delete-modal").modal("hide");
                getAll();
            },
            error: function () {
                $("#manufacturer-delete-modal").modal("hide");
            }
        })
    }

    $("#add-manufacturer").click(function () {
        fillModal(null)
    })

    function fillModal(entity){
        $("input[name='manufacturer-id']").attr("disabled", "disabled");
        if (entity != null){
            $("input[name='manufacturer-id']").val(entity.id);
            $("input[name='manufacturer-name']").val(entity.name);
            $("textarea[name='manufacturer-address']").val(entity.address);
        } else {
            $("input[name='manufacturer-id']").val("");
            $("input[name='manufacturer-name']").val("");
            $("textarea[name='manufacturer-address']").val("");
            image = null;
        }
    }

    $("#save-manufacturer").click(function () {
        console.log(image);
        let id = $("input[name='manufacturer-id']").val();
        if (id == "") id = null;
        let name = $("input[name='manufacturer-name']").val();
        let address = $("textarea[name='manufacturer-address']").val();

        let formData = new FormData();
        formData.append("image", image);
        formData.append("id", id);
        formData.append("name", name);
        formData.append("address", address);
        save(formData);
    });

    $("#delete-manufacturer").click(function () {
        deleteManufacturer(selectId);
    });

    $("button[data-target='#manufacturer-modal']").click(function () {
        $("#manufacturer-modal-title").text("Add Manufacturer");
        $("input[name='manufacturer-name']").val("");
        $("textarea[name='manufacturer-description']").val("");
    });

    $("#search-manufacturer-button").click(function () {
        search($("#manufacturer-search-input").val());
    });

    $("#manufacturer-refresh-button").click(function () {
        getAll();
    });

    $("#image-input").change(function () {
        image = this.files[0];
    });

})(jQuery);