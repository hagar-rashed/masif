$(document).ready(function () {
    $("#createTalkForm").validate({
        // initialize the plugin

        rules: {
            name_ar: {
                required: true,
            },
            name_en: {
                required: true,
            },
            job_title_ar: {
                required: true,
            },
            job_title_en: {
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

    $("#updateTalkForm").validate({
        // initialize the plugin

        rules: {
            name_ar: {
                required: true,
            },
            name_en: {
                required: true,
            },
            job_title_ar: {
                required: true,
            },
            job_title_en: {
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
