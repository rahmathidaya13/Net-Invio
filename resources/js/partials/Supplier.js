import TextToNumber from "../helpers/TextToNumber";
import Limit from "../helpers/Limit";
import liveSearch from "../helpers/LiveSearch";
import paginations from "../helpers/Pagination";
import sortOrder from "../helpers/SortOrder";
import destroy from "../helpers/Destroys";
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
        destroy({
            selector: ".hapus",
            data: () => $(".hapus").data("data"),
            id: 'id_supplier',
            column: "nama",
            url: "/supplier/destroy",
        });


    });
}
