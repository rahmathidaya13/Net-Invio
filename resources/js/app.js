// import $ from "jquery";
// window.$ = $;
// window.jQuery = $;
import "./bootstrap";
import "../assets/js/scripts.js";
import "./routes";
import "./GlobalHelper.js";
import Logout from "./partials/Logout.js";
import clock from "./partials/ClockMoment.js";
// import "./helpers/NetworkHelper.js";
clock();
Logout();
document.addEventListener("DOMContentLoaded", function () {
    $(".select2").select2({
        theme: "bootstrap-5", // Opsional, jika pakai theme Bootstrap 5
        width: "100%", // Pastikan lebar penuh
    });
});
