export default function SweatAlert(uri, data, method) {
    Swal.fire({
        title: "Apakah kamu yakin?",
        text: `Data dipilih ${data} akan dihapus! tindakan ini tidak dapat mengembalikan data`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#B82132",
        confirmButtonText: "Ya, hapus!",
        cancelButtonColor: "#d33",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit the form if user confirms
            $.ajax({
                type: method,
                url: uri,
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                dataType: "json",
                success: function () {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: `${data} berhasil dihapus.`,
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Terjadi kesalahan",
                        text: "Saat menghapus item.",
                    });
                },
            });
        }
    });
}
