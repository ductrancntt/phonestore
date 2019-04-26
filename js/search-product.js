let min = null;

let max = null;

let selectedManufacturers = new Set();

let url = new URL(window.location.href);

(function ($) {



    try {
        let manufacturers = url.searchParams.get("manufacturers").split(",");
        manufacturers.forEach(function (id) {
            $("#" + id + "m").prop('checked', true);
            selectedManufacturers.add(id);
        });
    } catch (e) {

    }

    min = url.searchParams.get("min");
    max = url.searchParams.get("max");

    $("#min-price").val(min);
    $("#max-price").val(max);

    $("#apply-button").click(function () {
        let url = "search-result.php?productName=" + $("#search-product").val();
        let manufacturers = Array.from(selectedManufacturers);
        if (manufacturers.length > 0) {
            url += "&manufacturers=";
            manufacturers.forEach(function (ele) {
                url += ele + ",";
            });
            url = url.substr(0, url.length - 1);
        }
        if (min != null && max != null) {
            url += "&min=" + min;
            url += "&max=" + max;
        }
        window.location.href = url;
    });

    $("#min-price").change(function () {
        if (max != null) {
            if ($(this).val() >= max) {
                $(this).val(max);
            } else
                min = $(this).val();
        } else {
            min = $(this).val();
        }
    });

    $("#max-price").change(function () {
        if (min != null) {
            if ($(this).val() <= min)
                $(this).val(min);
            else
                max = $(this).val();
        } else {
            max = $(this).val();
        }
    });

    $("#clear-button").click(function () {
        min = null;
        max = null;
        $("#min-price").val("");
        $("#max-price").val("");
    });

    $("#check-all").change(function () {
        $("input[type='checkbox']").prop('checked', $(this).prop("checked"));
        if ($(this).prop("checked")) {
            $(".brand-checkbox").each(function () {
                selectedManufacturers.add(this.value);
            });
        } else {
            selectedManufacturers.clear();
        }
    });

    $(".brand-checkbox").each(function () {
        $(this).change(function () {
            if ($(this).prop("checked")) {
                selectedManufacturers.add(this.value);
                isCheckedAll();
            } else {
                selectedManufacturers.delete(this.value);
                $("#check-all").prop("checked", false);
            }
        });
    });

    let isCheckedAll = function () {
        let checkedAll = true;
        $(".brand-checkbox").each(function () {
            if (!selectedManufacturers.has(this.value))
                checkedAll = false;
        });

        if (checkedAll)
            $("#check-all").prop("checked", true);
        else
            $("#check-all").prop("checked", false);

        return checkedAll;
    }

    isCheckedAll();

    if (min != null && max != null) {
        $("#price-range").addClass('show');
    }



})(jQuery);