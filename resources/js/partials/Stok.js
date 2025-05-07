export default function Stok() {
    $(function () {
        $(document)
            .off("input", "#jumlah")
            .on("input", "#jumlah", function (e) {
                e.preventDefault();
                let numberFormat = $(this).val();
                $(this).val(TextToNumber(numberFormat));
            });

        // field untuk cari semua item dalam table
        $(document).off("input", "#keyword").on("input", "#keyword", function (e) {
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
            let setOrder = $("#sort_order").val() || "desc";
            $.ajax({
                type: "GET",
                url: "/stok/list",
                data: {
                    keyword: keyword,
                    _token: token,
                    limit: setLimit,
                    sort_order: setOrder,
                    page: urlPageParameter,
                },
                dataType: "json",
                success: function (data) {
                    $("tbody#stok_tabel").html(data.table);
                    $(".pagination-wrapper").html(data.pagination);
                    $("#informasi").html(
                        `Menampilkan <b>${data.info.firstItem ?? 0
                        }</b> sampai <b>${data.info.lastItem ?? 0
                        }</b> dari <b>${data.info.total ?? 0}</b> item`
                    );
                    HighlightText(keyword, ".nama_Barang");
                },
            });
        });

        // field untuk set order  dalam table
        $(document).off("change", "#sort_order").on("change", "#sort_order", function (e) {
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
            let setLimit = parseInt($("#limit").val());
            // buat order
            let setOrder = $(this).val();
            $.ajax({
                type: "GET",
                url: "/stok/list",
                data: {
                    keyword: keyword,
                    _token: token,
                    limit: setLimit,
                    sort_order: setOrder,
                    page: urlPageParameter,
                },
                dataType: "json",
                success: function (data) {
                    $("tbody#stok_tabel").html(data.table);
                    $(".pagination-wrapper").html(data.pagination);
                    $("#informasi").html(
                        `Menampilkan <b>${data.info.firstItem ?? 0
                        }</b> sampai <b>${data.info.lastItem ?? 0
                        }</b> dari <b>${data.info.total ?? 0}</b> item`
                    );
                    HighlightText(keyword, ".nama_barang");
                },
            });
        });
        // field untuk ganti batas item dalam table
        $(document).off("change", "#limit").on("change", "#limit", function (e) {
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
            let setOrder = $("#sort_order").val() || "desc";
            $.ajax({
                type: "GET",
                url: "/stok/list",
                data: {
                    keyword: keyword,
                    _token: token,
                    limit: setLimit,
                    sort_order: setOrder,
                    page: urlPageParameter,
                },
                dataType: "json",
                success: function (data) {
                    $("tbody#stok_tabel").html(data.table);
                    $(".pagination-wrapper").html(data.pagination);
                    $("#informasi").html(
                        `Menampilkan <b>${data.info.firstItem ?? 0
                        }</b> sampai <b>${data.info.lastItem ?? 0
                        }</b> dari <b>${data.info.total ?? 0}</b> item`
                    );
                    HighlightText(keyword, ".nama_barang");
                },
            });
        });

        // set pagination parameters
        $(document).off("click", ".pagination a").on("click", ".pagination a", function (e) {
            e.preventDefault();
            let urls = $(this).attr("href");
            let keyword = $("#keyword").val();
            let setLimit = parseInt($("#limit").val());
            let setOrder = $("#sort_order").val() || "desc";
            if (!urls) return; // Jika tidak ada URL, hentikan
            urls = new URL(urls, window.location.origin);
            urls.searchParams.set("limit", setLimit);
            urls.searchParams.set("keyword", keyword);
            urls.searchParams.set("sort_order", setOrder);
            $.ajax({
                type: "GET",
                url: urls.toString(),
                dataType: "json", // Pastikan menerima JSON
                success: function (data) {
                    $("tbody#stok_tabel").html(data.table);
                    $(".pagination-wrapper").html(data.pagination);
                    $("#informasi").html(
                        `Menampilkan <b>${data.info.firstItem ?? 0
                        }</b> sampai <b>${data.info.lastItem ?? 0
                        }</b> dari <b>${data.info.total ?? 0}</b> item`
                    );
                    HighlightText(keyword, ".nama_barang");
                },
            });
        });
        // hapuss per item
        $(document).off("click", ".hapus").on("click", ".hapus", function (e) {
            e.stopPropagation(); // Mencegah event bubbling ke elemen parent
            let data = $(this).data("data");
            // let form = $("#deleted_" + data.id_barang);
            SweatAlert(
                `/stok/destroy/${data.id_stok}`,
                data.nama_barang,
                "delete"
            );
        });
    });
}
