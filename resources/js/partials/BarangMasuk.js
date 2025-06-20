import TextToNumber from "../helpers/TextToNumber";
import Limit from "../helpers/Limit";
import liveSearch from "../helpers/LiveSearch";
import paginations from "../helpers/Pagination";
import sortOrder from "../helpers/SortOrder";
import Currency from "../helpers/Currency";
import SweatAlert from "../helpers/SweatAlert";
export default function BarangMasuk() {
    $(function () {
        $(document)
            .off("input", "#jumlah")
            .on("input", "#jumlah", function (e) {
                e.preventDefault();
                let numberFormat = $(this).val();
                $(this).val(TextToNumber(numberFormat));
            });

        $(document)
            .off("input", "#harga")
            .on("input", "#harga", function (e) {
                e.preventDefault();
                let value = $(this).val();
                let formated = TextToNumber(value);
                $(this).val(Currency(formated));
            });

        $(document)
            .off("change", "#nama_barang")
            .on("change", "#nama_barang", function (e) {
                e.preventDefault();
                let selected = $(this).val();
                $("#id_barang").val(selected);
            });
        $(document).on("change", "#lokasi", function (e) {
            e.preventDefault();
            let selected = $(this).val();
            $("#lokasi_barang").val(selected);
        });

        // field untuk cari semua item dalam table
        liveSearch({
            inputSelector: "#keyword",
            getLimit: () => parseInt($("#limit").val()),
            getSortOrder: () => $("#sort_order").val() || "desc",
            tableId: "tbody#barang_masuk_tabel",
            url: "/receiving/list",
            highlightText: ".nama_barang,.nama_supplier,.kode_brg_masuk",
        });

        // field untuk ganti batas item dalam table
        sortOrder({
            inputSelector: "#sort_order",
            getKeyword: () => $("#keyword").val(),
            getLimit: () => parseInt($("#limit").val()),
            tableId: "tbody#barang_masuk_tabel",
            url: "/receiving/list",
            highlightText: ".nama_barang,.nama_supplier,.kode_brg_masuk",
        });

        // field untuk ganti batas item dalam table
        Limit({
            inputSelector: "#limit",
            getKeyword: () => $("#keyword").val(),
            getSortOrder: () => $("#sort_order").val() || "desc",
            tableId: "tbody#barang_masuk_tabel",
            url: "/receiving/list",
            highlightText: ".nama_barang,.nama_supplier,.kode_brg_masuk",
        });

        // pagination
        paginations({
            selector: ".pagination a",
            getKeyword: () => $("#keyword").val(),
            getLimit: () => parseInt($("#limit").val()),
            getSortOrder: () => $("#sort_order").val() || "desc",
            tableId: "tbody#barang_masuk_tabel",
            highlightText: ".nama_barang,.nama_supplier,.kode_brg_masuk",
        });

        // hapuss per item
        $(document)
            .off("change", ".hapus")
            .on("click", ".hapus", function (e) {
                e.preventDefault(); // Mencegah event bubbling ke elemen parent
                let data = $(this).data("data");
                SweatAlert(
                    `/receiving/destroy/${data.id_barang_masuk}`,
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
