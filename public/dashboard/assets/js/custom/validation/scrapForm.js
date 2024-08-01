$(document).ready(function () {
    $("#createScrapForm").validate({
        // initialize the plugin

        rules: {
            image: {
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

    $("#updateScrapForm").validate({
        // initialize the plugin

        rules: {
            // image: {
            //     required: true,
            // },
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
