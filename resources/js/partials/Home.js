export default function home() {
    $(function () {
        $(document)
            .off("click", "#backup")
            .on("click", "#backup", function (e) {
                e.preventDefault();
                const button = $(this);
                Swal.fire({
                    title: "Backup Database",
                    text: "Apakah anda yakin ingin melakukan backup database?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Backup!",
                    cancelButtonText: "Batal",
                }).then((result) => {
                    if (result.isConfirmed) {
                        button.prop("disabled", true).text("Membuat Backup...");
                        $.ajax({
                            method: "GET",
                            url: "/backup",
                            xhrFields: {
                                responseType: "blob",
                            },
                            success: function (data, status, xhr) {
                                let filename = "";
                                const disposition = xhr.getResponseHeader(
                                    "Content-Disposition"
                                );
                                if (
                                    disposition &&
                                    disposition.indexOf("attachment") !== -1
                                ) {
                                    const match =
                                        disposition.match(/filename="?(.+)"?/);
                                    if (match && match[1]) filename = match[1];
                                }

                                const blob = new Blob([data]);
                                const link = document.createElement("a");
                                link.href = window.URL.createObjectURL(blob);
                                link.download = filename;
                                document.body.appendChild(link);
                                link.click();
                                document.body.removeChild(link);

                                Swal.fire({
                                    icon: "success",
                                    title: "Backup berhasil!",
                                    text: "File telah berhasil diunduh.",
                                    timer: 3000,
                                    showConfirmButton: false,
                                });
                                button.prop("disabled", false).text("Backup");
                            },
                            error: function () {
                                Swal.fire({
                                    icon: "error",
                                    title: "Gagal!",
                                    text: "Terjadi kesalahan saat melakukan backup.",
                                });

                                button.prop("disabled", false).text("Backup");
                            },
                        });
                    }
                });
            });
    });
}
