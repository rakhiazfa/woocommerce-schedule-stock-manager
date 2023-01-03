document.addEventListener("DOMContentLoaded", function (event) {
    var wssmgwsScheduleMode = document.querySelector("#wssmgws_schedule_mode");

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
