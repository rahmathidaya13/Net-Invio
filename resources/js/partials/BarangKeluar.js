export default function BarangKeluar() {
    $(function () {
        // get url and set parameter

        $(document).on("change", "#nama_barang", function (e) {
            e.preventDefault();
            let id_barang = $(this).val();
            $("#id_barang").val(id_barang);
        });
        $(document).on("change", "#lokasi", function (e) {
            e.preventDefault();
            let lokasi = $(this).val();
            let id_barang = $("#nama_barang").val();
            if (!id_barang && !lokasi) return;
            $.ajax({
                type: "GET",
                url: `/stok/show/${id_barang}/${lokasi}`,
                dataType: "json",
                success: function (response) {
                    $("#sisa_stok").val(response.stok?.jumlah_barang ?? 0);
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
    });
}
