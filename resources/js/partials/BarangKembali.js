import { data, each } from "jquery";

export default function BarangKembali() {
    $(function () {
        $(document)
            .off("input", "#jumlah")
            .on("input", "#jumlah", function (e) {
                e.preventDefault();
                let numberFormat = $(this).val();
                $(this).val(TextToNumber(numberFormat));
            });

        $(document)
            .off("change", "#barang")
            .on("change", "#barang", function (e) {
                e.preventDefault();
                let selected = $(this).val();
                $("#id_barang").val(selected);
            });
        $(document)
            .off("change", "#pelanggan")
            .on("change", "#pelanggan", function (e) {
                e.preventDefault();
                let selected = $(this).val();
                $("#id_pelanggan").val(selected);
            });
        $(document)
            .off("change", "#supplier")
            .on("change", "#supplier", function (e) {
                e.preventDefault();
                let selected = $(this).val();
                $("#id_supplier").val(selected);
            });

        $(".gambar-input").on("change", function () {
            // Klik gambar-0 → hanya <img id="preview-0"> yang berubah.
            // Klik gambar-1 → hanya <img id="preview-1"> yang berubah.
            const input = this;
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    // Ambil index dari ID input misalnya: "gambar-1" → 1
                    const index = $(input).attr("id").split("-")[1];
                    console.log(index);
                    $("#preview-" + index).attr("src", e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });

        // load gambar pada sweet alert
        $(document).on("click", ".image-view", function (e) {
            e.preventDefault();
            let noImage = "/assets/image/no-image.svg";
            let dataImage = $(this).data("data");
            let getImage = dataImage.split(","); // value sudah diasumsikan merupakan path seperti assets/uploads/namafile.jpg.
            let htmlContent = ""; // html: digunakan agar kamu bisa me-render banyak gambar di satu SweetAlert.
            $.each(getImage, function (index, value) {
                // load element img with swall in container
                htmlContent += `
                    <img src="${
                        dataImage !== "" ? "/assets/uploads/" + value : noImage
                    }" class="img-thumbnail img-responsive"  alt="gambar-${index}">
                `;
            });
            Swal.fire({
                title: "Preview Image",
                html: htmlContent, // Gambar ditampilkan dalam bentuk kecil (thumbnail) agar bisa muat banyak.
                width: "600px",
                showCloseButton: false,
                showCancelButton: false,
                showConfirmButton: false,
            });
        });

        // live search
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
                    url: "/retur/list",
                    data: {
                        keyword: keyword,
                        _token: token,
                        limit: setLimit,
                        sort_order: setOrder,
                        page: urlPageParameter,
                    },
                    dataType: "json",
                    success: function (data) {
                        $("tbody#barang_kembali_tabel").html(data.table);
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
                            ".nama_barang,.nama_pelanggan,.kode_retur"
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
                    url: "/retur/list",
                    data: {
                        keyword: keyword,
                        _token: token,
                        limit: setLimit,
                        sort_order: setOrder,
                        page: urlPageParameter,
                    },
                    dataType: "json",
                    success: function (data) {
                        $("tbody#barang_kembali_tabel").html(data.table);
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
                            ".nama_barang,.nama_pelanggan,.kode_retur"
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
                    url: "/retur/list",
                    data: {
                        keyword: keyword,
                        _token: token,
                        limit: setLimit,
                        sort_order: setOrder,
                        page: urlPageParameter,
                    },
                    dataType: "json",
                    success: function (data) {
                        $("tbody#barang_kembali_tabel").html(data.table);
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
                            ".nama_barang,.nama_pelanggan,.kode_retur"
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
                        $("tbody#barang_kembali_tabel").html(data.table);
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
                            ".nama_barang,.nama_pelanggan,.kode_retur"
                        );
                    },
                });
            });

        $(document)
            .off("change", ".hapus")
            .on("click", ".hapus", function (e) {
                e.preventDefault(); // Mencegah event bubbling ke elemen parent
                let data = $(this).data("data");
                SweatAlert(
                    `/retur/destroy/${data.id_retur}`,
                    data.nama_barang,
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
