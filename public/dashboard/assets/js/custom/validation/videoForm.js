$(document).ready(function () {
    $("#createVideoForm").validate({
        // initialize the plugin

        rules: {
            title_ar: {
                required: true,
            },
            title_en: {
                required: true,
            },
            url: {
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

    $("#updateVideoForm").validate({
        // initialize the plugin

        rules: {
            title_ar: {
                required: true,
            },
            title_en: {
                required: true,
            },
            url: {
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
