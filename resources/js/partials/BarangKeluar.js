export default function BarangKeluar() {
    $(function () {
        // get url and set parameter
        let idStok = $("#id_stok").val();
        if (idStok) {
            $.getJSON(`/stok/show/${idStok}`, function (response) {
                const values = response.stok?.jumlah_barang ?? 0;
                const no_warehouse = response.stok?.no_warehouse ?? "";
                $("#sisa_stok").val(values);
                $("#no_warehouse").val(no_warehouse);
            });
        }
        $(document).off("change", "#barang").on("change", "#barang", function (e) {
            e.preventDefault();
            let id = $(this).val();
            if (!id) return;
            $.ajax({
                type: "GET",
                url: `/stok/show/${id}`,
                dataType: "json",
                success: function (response) {
                    $("#id_stok").val(response.stok?.id_stok);
                    $("#id_barang").val(response.stok?.id_barang);
                    $("#sisa_stok").val(response.stok?.jumlah_barang ?? 0);
                    $("#lokasi").val(response.stok?.lokasi);
                    $("#no_warehouse").val(response.stok?.no_warehouse);
                },
            });
        });

        $(document)
            .off("input", "#jumlah")
            .on("input", "#jumlah", function (e) {
                e.preventDefault();
                let numberFormat = $(this).val();
                $(this).val(TextToNumber(numberFormat));
            });

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
                    url: "/outbound/list",
                    data: {
                        keyword: keyword,
                        _token: token,
                        limit: setLimit,
                        sort_order: setOrder,
                        page: urlPageParameter,
                    },
                    dataType: "json",
                    success: function (data) {
                        $("tbody#barang_keluar_tabel").html(data.table);
                        $(".pagination-wrapper").html(data.pagination);
                        $("#informasi").html(
                            `Menampilkan <b>${data.info.firstItem ?? 0
                            }</b> sampai <b>${data.info.lastItem ?? 0
                            }</b> dari <b>${data.info.total ?? 0}</b> item`
                        );
                        HighlightText(keyword, ".nama_barang,.nama_pelanggan");
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
                let setOrder = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "/outbound/list",
                    data: {
                        keyword: keyword,
                        _token: token,
                        limit: setLimit,
                        sort_order: setOrder,
                        page: urlPageParameter,
                    },
                    dataType: "json",
                    success: function (data) {
                        $("tbody#barang_keluar_tabel").html(data.table);
                        $(".pagination-wrapper").html(data.pagination);
                        $("#informasi").html(
                            `Menampilkan <b>${data.info.firstItem ?? 0
                            }</b> sampai <b>${data.info.lastItem ?? 0
                            }</b> dari <b>${data.info.total ?? 0}</b> item`
                        );
                        HighlightText(keyword, ".nama_barang,.nama_pelanggan");
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
                    url: "/outbound/list",
                    data: {
                        keyword: keyword,
                        _token: token,
                        limit: setLimit,
                        sort_order: setOrder,
                        page: urlPageParameter,
                    },
                    dataType: "json",
                    success: function (data) {
                        $("tbody#barang_keluar_tabel").html(data.table);
                        $(".pagination-wrapper").html(data.pagination);
                        $("#informasi").html(
                            `Menampilkan <b>${data.info.firstItem ?? 0
                            }</b> sampai <b>${data.info.lastItem ?? 0
                            }</b> dari <b>${data.info.total ?? 0}</b> item`
                        );
                        HighlightText(keyword, ".nama_barang,.nama_pelanggan");
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
                        $("tbody#barang_keluar_tabel").html(data.table);
                        $(".pagination-wrapper").html(data.pagination);
                        $("#informasi").html(
                            `Menampilkan <b>${data.info.firstItem ?? 0
                            }</b> sampai <b>${data.info.lastItem ?? 0
                            }</b> dari <b>${data.info.total ?? 0}</b> item`
                        );
                        HighlightText(keyword, ".nama_barang,.nama_pelanggan");
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
                    `/outbound/destroy/${data.id_barang_keluar}`,
                    data.nama_barang,
                    "delete"
                );
            });


        // Cek saat dokumen dibuka
        $('#tanggal_awal,#tanggal_akhir').on('input change', function () {
            const awalExcell = $('#tanggal_awal').val();
            const akhirExcell = $('#tanggal_akhir').val();
            if (awalExcell && akhirExcell) {
                $('#print_excell').prop('disabled', false);
            } else {
                $('#print_excell').prop('disabled', true);
            }
        });

        $('#tanggal_awal_pdf,#tanggal_akhir_pdf').on('input change', function () {
            const awalPDF = $('#tanggal_awal_pdf').val();
            const akhirPDF = $('#tanggal_akhir_pdf').val();
            if (awalPDF && akhirPDF) {
                $('#print_pdf').prop('disabled', false);
            } else {
                $('#print_pdf').prop('disabled', true);
            }
        });
    });
}
