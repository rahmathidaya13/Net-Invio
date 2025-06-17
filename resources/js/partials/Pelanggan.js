export default function Pelanggan() {
    $(function () {
        // convert type text input can number
        $(document)
            .off("input", "#nid")
            .on("input", "#nid", function (e) {
                e.preventDefault();
                let numberFormat = $(this).val();
                $(this).val(TextToNumber(numberFormat));
            });
        $(document)
            .off("input", "#nohp")
            .on("input", "#nohp", function (e) {
                e.preventDefault();
                let numberFormat = $(this).val();
                $(this).val(TextToNumber(numberFormat));
            });
        // end convert text to number

        // field untuk cari semua item dalam table
        $(document)
            .off("input", "#keyword")
            .on("input", "#keyword", function (e) {
                e.preventDefault();
                // ambil keyword
                let keyword = $(this).val();
                if (keyword.length > 0) {
                    $("#text-result").removeClass("d-none").addClass("d-block");
                    $("#results").text(` "${keyword}" `);
                } else {
                    $("#text-result").removeClass("d-block").addClass("d-none");
                    $("#results").text("");
                }
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
                    url: "/pelanggan/list",
                    data: {
                        keyword: keyword,
                        _token: token,
                        limit: setLimit,
                        sort_order: setOrder,
                        page: urlPageParameter,
                    },
                    dataType: "json",
                    success: function (data) {
                        $("tbody#pelanggan_tabel").html(data.table);
                        $(".pagination-wrapper").html(data.pagination);
                        $("#informasi").html(
                            `Menampilkan <b>${
                                data.info.firstItem ?? 0
                            }</b> sampai <b>${
                                data.info.lastItem ?? 0
                            }</b> dari <b>${data.info.total ?? 0}</b> item`
                        );
                        HighlightText(
                            keyword,
                            ".nama_pelanggan,.nohp,.no_identitas"
                        );
                    },
                });
            });

        // field untuk set order  dalam table
        $(document)
            .off("change", "#sort_order")
            .on("change", "#sort_order", function (e) {
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
                let setOrder = $(this).val() || "desc";
                $.ajax({
                    type: "GET",
                    url: "/pelanggan/list",
                    data: {
                        keyword: keyword,
                        _token: token,
                        limit: setLimit,
                        sort_order: setOrder,
                        page: urlPageParameter,
                    },
                    dataType: "json",
                    success: function (data) {
                        $("tbody#pelanggan_tabel").html(data.table);
                        $(".pagination-wrapper").html(data.pagination);
                        $("#informasi").html(
                            `Menampilkan <b>${
                                data.info.firstItem ?? 0
                            }</b> sampai <b>${
                                data.info.lastItem ?? 0
                            }</b> dari <b>${data.info.total ?? 0}</b> item`
                        );
                        HighlightText(
                            keyword,
                            ".nama_pelanggan,.nohp,.no_identitas"
                        );
                    },
                });
            });
        // field untuk ganti batas item dalam table
        $(document)
            .off("change", "#limit")
            .on("change", "#limit", function (e) {
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
                    url: "/pelanggan/list",
                    data: {
                        keyword: keyword,
                        _token: token,
                        limit: setLimit,
                        sort_order: setOrder,
                        page: urlPageParameter,
                    },
                    dataType: "json",
                    success: function (data) {
                        $("tbody#pelanggan_tabel").html(data.table);
                        $(".pagination-wrapper").html(data.pagination);
                        $("#informasi").html(
                            `Menampilkan <b>${
                                data.info.firstItem ?? 0
                            }</b> sampai <b>${
                                data.info.lastItem ?? 0
                            }</b> dari <b>${data.info.total ?? 0}</b> item`
                        );
                        HighlightText(
                            keyword,
                            ".nama_pelanggan,.nohp,.no_identitas"
                        );
                    },
                });
            });

        // set pagination parameters
        $(document)
            .off("click", ".pagination a")
            .on("click", ".pagination a", function (e) {
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
                        $("tbody#pelanggan_tabel").html(data.table);
                        $(".pagination-wrapper").html(data.pagination);
                        $("#informasi").html(
                            `Menampilkan <b>${
                                data.info.firstItem ?? 0
                            }</b> sampai <b>${
                                data.info.lastItem ?? 0
                            }</b> dari <b>${data.info.total ?? 0}</b> item`
                        );
                        HighlightText(
                            keyword,
                            ".nama_pelanggan,.nohp,.no_identitas"
                        );
                    },
                });
            });

        // hapuss per item
        $(document)
            .off("change", ".hapus")
            .on("click", ".hapus", function (e) {
                e.preventDefault(); // Mencegah event bubbling ke elemen parent
                let data = $(this).data("data");
                SweatAlert(
                    `/pelanggan/destroy/${data.id_pelanggan}`,
                    data.nama,
                    "delete"
                );
            });

        // Cek saat dokumen dibuka
        $("#tanggal_awal,#tanggal_akhir").on("input change", function () {
            const awalExcell = $("#tanggal_awal").val();
            const akhirExcell = $("#tanggal_akhir").val();
            if (awalExcell && akhirExcell) {
                $("#print_excell").prop("disabled", false);
            } else {
                $("#print_excell").prop("disabled", true);
            }
        });

        $("#tanggal_awal_pdf,#tanggal_akhir_pdf").on(
            "input change",
            function () {
                const awalPDF = $("#tanggal_awal_pdf").val();
                const akhirPDF = $("#tanggal_akhir_pdf").val();
                if (awalPDF && akhirPDF) {
                    $("#print_pdf").prop("disabled", false);
                } else {
                    $("#print_pdf").prop("disabled", true);
                }
            }
        );
    });
}
