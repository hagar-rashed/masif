$(document).ready(function () {
    $("#createAboutForm").validate({
        // initialize the plugin

        rules: {
            type: {
                required: true,
            },
            desc_ar: {
                required: true,
            },
            desc_en: {
                required: true,
            },
        },

        errorElement: "span",
        errorLabelContainer: ".errorTxt",

        submitHandler: function (form) {
            form.submit();
        },
    });

    $("#updateAboutForm").validate({
        // initialize the plugin

        rules: {
            type: {
                required: true,
            },
            desc_ar: {
                required: true,
            },
            desc_en: {
                required: true,
            },
        },

        errorElement: "span",
        errorLabelContainer: ".errorTxt",

        submitHandler: function (form) {
            form.submit();
        },
    });
});
