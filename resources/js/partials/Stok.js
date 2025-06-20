import Limit from "../helpers/Limit";
import liveSearch from "../helpers/LiveSearch";
import paginations from "../helpers/Pagination";
import sortOrder from "../helpers/SortOrder";
import TextToNumber from "../helpers/TextToNumber";
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
        liveSearch({
            inputSelector: "#keyword",
            getLimit: () => parseInt($("#limit").val()),
            getSortOrder: () => $("#sort_order").val() || "desc",
            tableId: "tbody#stok_tabel",
            url: "/stok/list",
            highlightText: ".nama_barang,.kode_stok"
        })

        // field untuk set order  dalam table
        sortOrder({
            inputSelector: "#sort_order",
            getKeyword: () => $("#keyword").val(),
            getLimit: () => parseInt($("#limit").val()),
            tableId: "tbody#stok_tabel",
            url: "/stok/list",
            highlightText: ".nama_barang,.kode_stok"
        })

        // field untuk ganti batas item dalam table
        Limit({
            inputSelector: "#limit",
            getKeyword: () => $("#keyword").val(),
            getSortOrder: () => $("#sort_order").val() || "desc",
            tableId: "tbody#stok_tabel",
            url: "/stok/list",
            highlightText: ".nama_barang,.kode_stok"
        })

        // set pagination parameters
        paginations({
            selector: ".pagination a",
            getKeyword: () => $("#keyword").val(),
            getLimit: () => parseInt($("#limit").val()),
            getSortOrder: () => $("#sort_order").val() || "desc",
            tableId: "tbody#stok_tabel",
            highlightText: ".nama_barang,.kode_stok"
        })

        // hapuss per item
        $(document)
            .off("click", ".hapus")
            .on("click", ".hapus", function (e) {
                e.preventDefault(); // Mencegah event bubbling ke elemen parent
                let data = $(this).data("data");
                // let form = $("#deleted_" + data.id_barang);
                SweatAlert(
                    `/stok/destroy/${data.id_stok}`,
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
