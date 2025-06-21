import destroy from "../helpers/Destroys";
import Limit from "../helpers/Limit";
import liveSearch from "../helpers/LiveSearch";
import paginations from "../helpers/Pagination";
import sortOrder from "../helpers/SortOrder";
import TextToNumber from "../helpers/TextToNumber";
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
        $(document)
            .off("change", "#barang")
            .on("change", "#barang", function (e) {
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

        liveSearch({
            inputSelector: "#keyword",
            getLimit: () => parseInt($("#limit").val()),
            getSortOrder: () => $("#sort_order").val() || "desc",
            tableId: "tbody#barang_keluar_tabel",
            url: "/outbound/list",
            highlightText: ".nama_barang,.nama_pelanggan,.kode_brg_keluar"
        });

        sortOrder({
            inputSelector: "#sort_order",
            getKeyword: () => $("#keyword").val(),
            getLimit: () => parseInt($("#limit").val()),
            tableId: "tbody#barang_keluar_tabel",
            url: "/outbound/list",
            highlightText: ".nama_barang,.nama_pelanggan,.kode_brg_keluar"
        })

        Limit({
            inputSelector: "#limit",
            getKeyword: () => $("#keyword").val(),
            getSortOrder: () => $("#sort_order").val() || "desc",
            tableId: "tbody#barang_keluar_tabel",
            url: "/outbound/list",
            highlightText: ".nama_barang,.nama_pelanggan,.kode_brg_keluar"
        });

        paginations({
            selector: ".pagination a",
            getKeyword: () => $("#keyword").val(),
            getLimit: () => parseInt($("#limit").val()),
            getSortOrder: () => $("#sort_order").val() || "desc",
            tableId: "tbody#barang_keluar_tabel",
            highlightText: ".nama_barang,.nama_pelanggan,.kode_brg_keluar"
        });

        destroy({
            selector: ".hapus",
            data: () => $(".hapus").data("data"),
            id: 'id_barang_keluar',
            column: "nama_barang",
            url: "/outbound/destroy",
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
