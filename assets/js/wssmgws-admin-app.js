document.addEventListener("DOMContentLoaded", function (event) {
    var wssmgwsManageStock = document.querySelector("#_manage_stock");
    var wssmgwsScheduleMode = document.querySelector("#wssmgws_schedule_mode");

    wssmgwsManageStock.addEventListener("change", function (event) {
        var wssmgwsAdditionalOption = document.querySelector(
            ".wssmgws_enable_manage_stock"
        );

        if (event.currentTarget.checked) {
            wssmgwsAdditionalOption.setAttribute("style", "display: block;");
        } else {
            wssmgwsAdditionalOption.setAttribute("style", "display: none;");
        }
    });

    wssmgwsScheduleMode.addEventListener("change", function (event) {
        var wssmgwsAdditionalOption = document.querySelector(
            ".wssmgws_additional_options"
        );

        if (event.currentTarget.checked) {
            wssmgwsAdditionalOption.setAttribute("style", "display: block;");
        } else {
            wssmgwsAdditionalOption.setAttribute("style", "display: none;");
        }
    });

    wssmgwsScheduleMode.addEventListener("change", function (event) {
        var wssmgwsAdditionalOption = document.querySelector(
            ".wssmgws_additional_options"
        );

        if (event.currentTarget.checked) {
            wssmgwsAdditionalOption.setAttribute("style", "display: block;");
        } else {
            wssmgwsAdditionalOption.setAttribute("style", "display: none;");
        }
    });

    var wssmgwsNumberField = document.querySelectorAll(".wssmgws_number_field");

    wssmgwsNumberField.forEach(function (field) {
        field.setAttribute("min", 0);
    });
});
