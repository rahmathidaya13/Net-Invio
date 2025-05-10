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
    });
}
