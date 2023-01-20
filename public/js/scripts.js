/*!
 * Start Bootstrap - SB Admin v7.0.5 (https://startbootstrap.com/template/sb-admin)
 * Copyright 2013-2022 Start Bootstrap
 * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
 */
//
// Scripts
//

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
            document.body.classList.toggle('sb-sidenav-toggled');
        }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

    $('.table').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/id.json",
            sEmptyTable: "Tidak ada data"
        },
        "aaSorting": []
    })

    $('#finish').submit(function (e) {
        e.preventDefault();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-danger me-3'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Yakin Selesai?',
            text: "anda akan menyelesaikan transaksi ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Selesai',
            cancelButtonText: 'Tutup',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).off("submit").submit();
            }
        })
    })

    $('.deleteForm').submit(function (e) {
        e.preventDefault();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-danger me-3'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Yakin hapus?',
            text: "data akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Tutup',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).off("submit").submit();
            }
        })
    })

    setTimeout(() => {
        $('#alert').html('');
    }, 5000);

    $('.price').keyup(function () {
        let value = $(this).val();
        $(this).val(formatRupiah(value));
    })

    let purchase_price = $('#harga_beli').val()
    let selling_price = $('#harga_jual').val()
    if (purchase_price || selling_price) {
        $('#harga_beli').val(formatRupiah(purchase_price));
        $('#harga_jual').val(formatRupiah(selling_price));
    }

    $('#generate').click(function () {
        $('#barcode').val(makeid());
    })

    function makeid() {
        let length = Math.floor(Math.random() * (8 - 6 + 1)) + 6;
        let result = '';
        let characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let charactersLength = characters.length;
        for (let i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }

    /* Fungsi formatRupiah */
    function formatRupiah(value) {
        let number_string = value.toString().replace(/[^,\d]/g, ""),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }

        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return rupiah;
    }

});
