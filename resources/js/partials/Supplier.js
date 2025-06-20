import TextToNumber from "../helpers/TextToNumber";
import Limit from "../helpers/Limit";
import liveSearch from "../helpers/LiveSearch";
import paginations from "../helpers/Pagination";
import sortOrder from "../helpers/SortOrder";
export default function Supplier() {
    $(function () {
        $(document)
            .off("input", "#kontak")
            .on("input", "#kontak", function (e) {
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
            tableId: "tbody#supplier_tabel",
            url: "/supplier/list",
            highlightText: ".nama_supplier,.kontak,.email",
        });

        sortOrder({
            inputSelector: "#sort_order",
            getKeyword: () => $("#keyword").val(),
            getLimit: () => parseInt($("#limit").val()),
            tableId: "tbody#supplier_tabel",
            url: "/supplier/list",
            highlightText: ".nama_supplier,.kontak,.email",
        });

        Limit({
            inputSelector: "#limit",
            getKeyword: () => $("#keyword").val(),
            getSortOrder: () => $("#sort_order").val() || "desc",
            tableId: "tbody#supplier_tabel",
            url: "/supplier/list",
            highlightText: ".nama_supplier,.kontak,.email",
        });

        paginations({
            tableId: "tbody#supplier_tabel",
            highlightText: ".nama_supplier,.kontak,.email",
            getKeyword: () => $("#keyword").val(),
            getLimit: () => parseInt($("#limit").val()),
            getSortOrder: () => $("#sort_order").val() || "desc",
            selector: ".pagination a",
        });

        // hapuss per item
        $(document)
            .off("click", ".hapus")
            .on("click", ".hapus", function (e) {
                e.stopPropagation(); // Mencegah event bubbling ke elemen parent
                let data = $(this).data("data");
                // let form = $("#deleted_" + data.id_barang);
                SweatAlert(
                    `/supplier/destroy/${data.id_supplier}`,
                    data.nama,
                    "delete"
                );
            });
    });
}
