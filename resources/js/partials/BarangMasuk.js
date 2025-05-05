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
            .off("change", "#sumber")
            .on("change", "#sumber", function (e) {
                e.preventDefault();
                // ambil nilai id didalam atribute data-id pada element option
                let selected = $(this).find("option:selected");
                let supplier = $("#suppliers").find("option:selected");
                let supplierValue = supplier.val();
                let newValue = selected.val();
                if (newValue === "supplier") {
                    $("#suppliers").prop("disabled", false);
                    $("#hide_supplier").val(supplierValue);
                } else {
                    $("#suppliers").prop("disabled", true);
                    $("#hide_supplier").val("");
                }
            });

        $(document)
            .off("change", "#suppliers")
            .on("change", "#suppliers", function (e) {
                e.preventDefault();
                // ambil nilai id didalam atribute data-id pada element option
                let selected = $(this).find("option:selected");
                let newValue = selected.val();
                $("#hide_supplier").val(newValue);
            });
    });
}
