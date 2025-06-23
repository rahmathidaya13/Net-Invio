export default function restore() {
    $(function () {
        $(document).on("change", "#restore", function (e) {
            e.preventDefault();
            let file = e.target.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function () {
                    $("#preview").attr("src", "/assets/icon/sql.png");
                };
                reader.readAsDataURL(file);
            }
        });
    });
}
