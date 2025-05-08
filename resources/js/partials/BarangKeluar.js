export default function BarangKeluar() {
    $(function () {
        $(document).on("change", "#nama_barang", function (e) {
            e.preventDefault();
            let id_barang = $(this).val();
            // $("#id_barang").val(id_barang);
            if (!id_barang) return;
            $.ajax({
                type: "GET",
                url: `/stok/show/${id_barang}`,
                dataType: "json",
                success: function (response) {
                    $("#id_barang").val(response.stok.id_barang);
                    $("#lokasi").val(response.stok.lokasi);
                    $("#sisa_stok").val(response.stok.jumlah_barang);
                }
            });
        });

        $(document)
            .off("input", "#jumlah")
            .on("input", "#jumlah", function (e) {
                e.preventDefault();
                let numberFormat = $(this).val();
                $(this).val(TextToNumber(numberFormat));
            });
    })
}
