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





    });
}
