export default function profile() {
    $(function () {
        // Your jQuery code here.
        $(document).on("change", "#pic_profile", function (e) {
            e.preventDefault();
            let file = e.target.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function (data) {
                    $("#preview").attr("src", data.target.result);
                };
                reader.readAsDataURL(file);
            }
            $('#picture_profile').append(this);
        });

        $(document)
            .off("input", "#phone")
            .on("input", "#phone", function (e) {
                e.preventDefault();
                let numberFormat = $(this).val();
                $(this).val(TextToNumber(numberFormat));
            });
    });
}
