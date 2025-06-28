import TextToNumber from "../helpers/TextToNumber";
import Limit from "../helpers/Limit";
import liveSearch from "../helpers/LiveSearch";
import paginations from "../helpers/Pagination";
import sortOrder from "../helpers/SortOrder";
import destroy from "../helpers/Destroys";
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
        liveSearch({
            inputSelector: "#keyword",
            getLimit: () => parseInt($("#limit").val()),
            getSortOrder: () => $("#sort_order").val() || "desc",
            tableId: "tbody#pelanggan_tabel",
            url: "/pelanggan/list",
            highlightText: ".nama_pelanggan,.nohp,.no_identitas",
        });

        // field untuk ganti batas item dalam table
        sortOrder({
            inputSelector: "#sort_order",
            getKeyword: () => $("#keyword").val(),
            getLimit: () => parseInt($("#limit").val()),
            tableId: "tbody#pelanggan_tabel",
            url: "/pelanggan/list",
            highlightText: ".nama_pelanggan,.nohp,.no_identitas",
        });

        // field untuk ganti batas item dalam table
        Limit({
            inputSelector: "#limit",
            getKeyword: () => $("#keyword").val(),
            getSortOrder: () => $("#sort_order").val() || "desc",
            tableId: "tbody#pelanggan_tabel",
            url: "/pelanggan/list",
            highlightText: ".nama_pelanggan,.nohp,.no_identitas",
        });

        // pagination
        paginations({
            selector: ".pagination a",
            getKeyword: () => $("#keyword").val(),
            getLimit: () => parseInt($("#limit").val()),
            getSortOrder: () => $("#sort_order").val() || "desc",
            tableId: "tbody#pelanggan_tabel",
            highlightText: ".nama_pelanggan,.nohp,.no_identitas",
        });

        // hapuss per item
        destroy({
            selector: ".hapus",
            id: 'id_pelanggan',
            column: "nama",
            url: "/pelanggan/destroy",
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

        // import
        $(document).on("change", "#file_import", function (e) {
            e.preventDefault();
            let file = e.target.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function (data) {
                    $("#preview").attr("src", "/assets/icon/icons-excel.svg");
                };
                reader.readAsDataURL(file);
            }
            $("#name-file").text(file.name);
        });
    });
}
