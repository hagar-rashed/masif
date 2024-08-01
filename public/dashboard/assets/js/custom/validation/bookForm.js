

$(document).ready(function () {
    $.validator.addMethod('greaterThanDate', function (value) {
        // get date today and compare with the date entered
        var today = new Date();
        var date = new Date(value);
        return date <= today;

    }, 'يجب ان يكون تاريخ النشر أصغر من او مساوى لتاريخ اليوم');


    $('#createBookForm').validate({ // initialize the plugin

        rules: {
            title: {
                required: true
            },
            publish_date: {
                required: true,
                greaterThanDate: true
            },
            image: {
                required: true
            },
            file: {
                required: true
            },
            pages: {
                required: true
            },
            folders: {
                required: true
            },
            // desc: {
            //     required: true
            // },
        },


        errorElement: "span",
        errorLabelContainer: '.errorTxt',

        submitHandler: function(form) {
            form.submit();
        }
    });

    $('#updateBookForm').validate({ // initialize the plugin

        rules: {
            title: {
                required: true
            },
            publish_date: {
                required: true,
                greaterThanDate: true
            },
            // image: {
            //     required: true
            // },
            // file: {
            //     required: true
            // },
            pages: {
                required: true
            },
            folders: {
                required: true
            },
            // desc: {
            //     required: true
            // },
        },


        errorElement: "span",
        errorLabelContainer: '.errorTxt',

        submitHandler: function(form) {
            form.submit();
        }
    });
});
