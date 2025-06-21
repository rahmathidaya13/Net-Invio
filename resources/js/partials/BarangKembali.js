import destroy from "../helpers/Destroys";
import Limit from "../helpers/Limit";
import liveSearch from "../helpers/LiveSearch";
import paginations from "../helpers/Pagination";
import sortOrder from "../helpers/SortOrder";
import TextToNumber from "../helpers/TextToNumber";
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
        liveSearch({
            inputSelector: "#keyword",
            getLimit: () => parseInt($("#limit").val()),
            getSortOrder: () => $("#sort_order").val() || "desc",
            tableId: "tbody#barang_kembali_tabel",
            url: "/retur/list",
            highlightText: ".nama_barang,.nama_pelanggan,.kode_retur",
        });

        // field untuk ganti batas item dalam table
        sortOrder({
            inputSelector: "#sort_order",
            getKeyword: () => $("#keyword").val(),
            getLimit: () => parseInt($("#limit").val()),
            tableId: "tbody#barang_kembali_tabel",
            url: "/retur/list",
            highlightText: ".nama_barang,.nama_pelanggan,.kode_retur",
        });

        // field untuk ganti batas item dalam table
        Limit({
            inputSelector: "#limit",
            getKeyword: () => $("#keyword").val(),
            getSortOrder: () => $("#sort_order").val() || "desc",
            tableId: "tbody#barang_kembali_tabel",
            url: "/retur/list",
            highlightText: ".nama_barang,.nama_pelanggan,.kode_retur",
        });

        // pagination
        paginations({
            selector: ".pagination a",
            getKeyword: () => $("#keyword").val(),
            getLimit: () => parseInt($("#limit").val()),
            getSortOrder: () => $("#sort_order").val() || "desc",
            tableId: "tbody#barang_kembali_tabel",
            highlightText: ".nama_barang,.nama_pelanggan,.kode_retur",
        });

        destroy({
            selector: ".hapus",
            data: ()=> $(".hapus").data("data"),
            id: "id_retur",
            column: "nama_barang",
            url: "/retur/destroy"
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
