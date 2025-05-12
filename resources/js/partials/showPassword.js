export default function showPassword() {
    $(function () {
        $(document).off("click", "#showPass").on("click", "#showPass", function (e) {
            e.preventDefault();
            let password = $("#password").prop("type");
            if (password === "password") {
                $("#password").prop("type", "text");
                $(this)
                    .removeClass("bi bi-eye-fill")
                    .addClass("bi bi-eye-slash-fill");
            } else {
                $("#password").prop("type", "password");
                $(this)
                    .removeClass("bi bi-eye-slash-fill")
                    .addClass("bi bi-eye-fill");
            }
        });
    });
}
