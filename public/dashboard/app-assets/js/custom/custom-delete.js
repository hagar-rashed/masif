$(document).ready(function () {
    var locale = $('html').attr('lang');

    var delet = locale === 'ar' ? 'حذف' : 'Delete';
    var no = locale === 'ar' ? 'لا' : 'No';
    var question = locale === 'ar' ? 'هل تريد الحذف؟' : 'Do you want to delete?';
    var success = locale === 'ar' ? 'تم الحذف بنجاح' : 'Deleted Successfully';
    var cancel = locale === 'ar' ? 'تم إلإلغاء' : 'Cancelled';

    $('.item-delete').click(function(e) {
        e.preventDefault();

        const Toast2 = Swal.mixin({
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        const Toast = Swal.mixin({
            showCancelButton: true,
            showConfirmButton: true,
            cancelButtonColor: '#888',
            confirmButtonColor: '#d6210f',
            confirmButtonText: delet,
            cancelButtonText: no,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'question',
            title: question
        }).then((result) => {
            if (result.isConfirmed) {
                var id = $(this).data('id');
                var url = $(this).data('url');
                var elem = $(this).closest('tr');

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        _method: 'DELETE',
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id: id,
                    },
                    success: function(response) {
                        elem.fadeOut();
                        Toast2.fire({
                            title: success,
                            icon: 'success',
                            timer: 1000
                        });
                    },
                    error: function(response) {
                        Toast2.fire({
                            title: 'Error deleting the unit. Please try again.',
                            icon: 'error',
                            timer: 1000
                        });
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Toast2.fire({
                    title: cancel,
                    icon: 'info',
                    timer: 1000
                });
            }
        });
    });


});
