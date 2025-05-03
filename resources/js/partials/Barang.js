export default function barang() {
    $(function () {
        // field untuk cari semua item dalam table
        $(document).on("input", "#keyword", function (e) {
            e.preventDefault();
            // ambil keyword
            let keyword = $(this).val();
            // ambil token CSRF-TOKEN
            let token = $('meta[name="csrf-token"]').attr("content");
            // ambil nilai page dari pagination
            let urlPageParameter = new URLSearchParams(
                window.location.search
            ).get("page");
            // buat limit
            let setLimit = parseInt($("#limit").val());
            $.ajax({
                type: "GET",
                url: "/barang/list",
                data: {
                    keyword: keyword,
                    _token: token,
                    limit: setLimit,
                    page: urlPageParameter,
                },
                dataType: "json",
                success: function (data) {
                    $("tbody#table_user").html(data.table);
                    $(".pagination-wrapper").html(data.pagination);
                    $("#informasi").html(
                        `Menampilkan <b>${data.info.firstItem ?? 0
                        }</b> sampai <b>${data.info.lastItem ?? 0
                        }</b> dari <b>${data.info.total ?? 0}</b> item`
                    );
                    HighlightText(
                        keyword,
                        ".kode,.nama_barang,.tipe_model,.serial_number"
                    );
                },
            });
        });

        // field untuk ganti batas item dalam table
        $(document).on("change", "#limit", function (e) {
            e.preventDefault();
            // ambil keyword
            let keyword = $("#keyword").val();
            // ambil token CSRF-TOKEN
            let token = $('meta[name="csrf-token"]').attr("content");
            // ambil nilai page dari pagination
            let urlPageParameter = new URLSearchParams(
                window.location.search
            ).get("page");
            // buat limit
            let setLimit = parseInt($(this).val());
            $.ajax({
                type: "GET",
                url: "/barang/list",
                data: {
                    keyword: keyword,
                    _token: token,
                    limit: setLimit,
                    page: urlPageParameter,
                },
                dataType: "json",
                success: function (data) {
                    $("tbody#table_user").html(data.table);
                    $(".pagination-wrapper").html(data.pagination);
                    $("#informasi").html(
                        `Menampilkan <b>${data.info.firstItem ?? 0
                        }</b> sampai <b>${data.info.lastItem ?? 0
                        }</b> dari <b>${data.info.total ?? 0}</b> item`
                    );
                    HighlightText(
                        keyword,
                        ".kode,.nama_barang,.tipe_model,.serial_number"
                    );
                },
            });
        });

        // set pagination parameters
        $(document).on("click", ".pagination a", function (e) {
            e.preventDefault();
            let urls = $(this).attr("href");
            let keyword = $("#keyword").val();
            let setLimit = parseInt($("#limit").val());
            if (!urls) return; // Jika tidak ada URL, hentikan
            urls = new URL(urls, window.location.origin);
            urls.searchParams.set("limit", setLimit);
            urls.searchParams.set("keyword", keyword);
            $.ajax({
                type: "GET",
                url: urls.toString(),
                dataType: "json", // Pastikan menerima JSON
                success: function (data) {
                    $("tbody#table_user").html(data.table);
                    $(".pagination-wrapper").html(data.pagination);
                    $("#informasi").html(
                        `Menampilkan <b>${data.info.firstItem ?? 0
                        }</b> sampai <b>${data.info.lastItem ?? 0
                        }</b> dari <b>${data.info.total ?? 0}</b> item`
                    );
                    HighlightText(
                        keyword,
                        ".kode,.nama_barang,.tipe_model,.serial_number"
                    );
                },
            });
        });


        // hapuss per item
        $(document).on("click", ".hapus", function (e) {
            e.stopPropagation(); // Mencegah event bubbling ke elemen parent
            let data = $(this).data("data");
            let form = $("#deleted_" + data.id_barang);

            Swal.fire({
                title: "Apakah kamu yakin?",
                text: `Data barang ${data.nama_barang} akan dihapus!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form if user confirms
                    form.submit();
                }
            });
        });

    });
}
