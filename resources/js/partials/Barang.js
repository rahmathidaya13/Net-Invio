import destroy from "../helpers/Destroys";
import Limit from "../helpers/Limit";
import liveSearch from "../helpers/LiveSearch";
import paginations from "../helpers/Pagination";
import sortOrder from "../helpers/SortOrder";
export default function barang() {
    $(function () {
        // field untuk cari semua item dalam table
        liveSearch({
            inputSelector: "#keyword",
            getLimit: () => parseInt($("#limit").val()),
            getSortOrder: () => $("#sort_order").val() || "desc",
            tableId: "tbody#table_user",
            url: "/barang/list",
            highlightText: ".kode,.nama_barang,.tipe_model,.serial_number"
        });

        // field untuk set order  dalam table
        sortOrder({
            inputSelector: "#sort_order",
            getKeyword: () => $("#keyword").val(),
            getLimit: () => parseInt($("#limit").val()),
            tableId: "tbody#table_user",
            url: "/barang/list",
            highlightText: ".kode,.nama_barang,.tipe_model,.serial_number"
        })

        // field untuk ganti batas item dalam table
        Limit({
            inputSelector: "#limit",
            getKeyword: () => $("#keyword").val(),
            getSortOrder: () => $("#sort_order").val() || "desc",
            tableId: "tbody#table_user",
            url: "/barang/list",
            highlightText: ".kode,.nama_barang,.tipe_model,.serial_number"
        });

        // set pagination parameters
        paginations({
            selector: ".pagination a",
            getKeyword: () => $("#keyword").val(),
            getLimit: () => parseInt($("#limit").val()),
            getSortOrder: () => $("#sort_order").val() || "desc",
            tableId: "tbody#table_user",
            highlightText: ".kode,.nama_barang,.tipe_model,.serial_number"
        });

        // hapus data record
        destroy({
            selector: ".hapus",
            data: () => $(".hapus").data("data"),
            id: 'id_barang',
            column: "nama_barang",
            url: "/barang/destroy",
        });

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
