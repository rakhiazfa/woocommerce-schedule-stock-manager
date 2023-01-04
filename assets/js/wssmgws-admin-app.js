document.addEventListener("DOMContentLoaded", function () {
    /**
     * Product Options
     *
     */

    var wssmgwsManageStock = document.querySelector("#_manage_stock");
    var wssmgwsScheduleMode = document.querySelector("#wssmgws_schedule_mode");

    wssmgwsManageStock.addEventListener("change", function (event) {
        var wssmgwsAdditionalOptions = document.querySelector(
            ".wssmgws_enable_manage_stock"
        );

        if (event.currentTarget.checked) {
            wssmgwsAdditionalOptions.setAttribute("style", "display: block;");
        } else {
            wssmgwsAdditionalOptions.setAttribute("style", "display: none;");
        }
    });

    wssmgwsScheduleMode.addEventListener("change", function (event) {
        var wssmgwsAdditionalOptions = document.querySelector(
            ".wssmgws_additional_options"
        );

        if (event.currentTarget.checked) {
            wssmgwsAdditionalOptions.setAttribute("style", "display: block;");
        } else {
            wssmgwsAdditionalOptions.setAttribute("style", "display: none;");
        }
    });

    /**
     * Variation Product Options
     *
     */

    var wssmgwsVariationTab = document.querySelector(".variations_tab");

    async function getWoocommerceVariations() {
        return new Promise((resolve) => {
            var interval;
            var woocommerceVariations;

            interval = setInterval(function () {
                woocommerceVariations = document.querySelectorAll(
                    ".woocommerce_variation"
                );

                if (woocommerceVariations.length !== 0) {
                    clearInterval(interval);
                    resolve(woocommerceVariations);
                }
            });
        });
    }

    wssmgwsVariationTab.addEventListener("click", function () {
        getWoocommerceVariations().then((variations) => {
            variations.forEach(function (variation) {
                //

                const variationManageStock = variation.querySelector(
                    ".variable_manage_stock"
                );

                variationManageStock.addEventListener(
                    "change",
                    function (event) {
                        var wssmgwsAdditionalVariationOptions =
                            variation.querySelector(
                                ".wssmgws_enable_variation_manage_stock"
                            );

                        if (event.currentTarget.checked) {
                            wssmgwsAdditionalVariationOptions.setAttribute(
                                "style",
                                "display: block;"
                            );
                        } else {
                            wssmgwsAdditionalVariationOptions.setAttribute(
                                "style",
                                "display: none;"
                            );
                        }
                    }
                );

                //

                var scheduleMode = variation.querySelector(
                    ".wssmgws_schedule_mode"
                );

                scheduleMode.addEventListener("change", function (event) {
                    var wssmgwsAdditionalVariationOptions =
                        variation.querySelector(
                            ".wssmgws_additional_variation_options"
                        );

                    if (event.currentTarget.checked) {
                        wssmgwsAdditionalVariationOptions.setAttribute(
                            "style",
                            "display: block;"
                        );
                    } else {
                        wssmgwsAdditionalVariationOptions.setAttribute(
                            "style",
                            "display: none;"
                        );
                    }
                });
            });
        });
    });

    /**
     * Set The Field's Minimum Value
     *
     */

    var wssmgwsNumberField = document.querySelectorAll(".wssmgws_number_field");

    wssmgwsNumberField.forEach(function (field) {
        field.setAttribute("min", 0);
    });
});
