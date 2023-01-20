$(document).ready(function () {
    "use strict"
    $('#logoutForm').submit(function (e) {
        e.preventDefault();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-danger me-3'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Yakin?',
            text: "kamu akan keluar!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Keluar',
            cancelButtonText: 'Tutup',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $("#logoutForm").off("submit").submit();
            }
        })
    });
});
