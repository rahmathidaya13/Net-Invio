export default function Logout() {
    $(function () {
        $(document)
            .off("click", "#logout")
            .on("click", "#logout", function (e) {
                e.preventDefault();
                let form = $("#logout-form");
                form.submit();
            });
    });
}
