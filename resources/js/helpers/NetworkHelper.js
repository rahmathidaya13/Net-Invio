// export default (function () {
//     // ubah status online/offline
//     function updateStatusColor(ping) {
//         const icon = $(".online-status");
//         icon.removeClass("green yellow red");

//         if (ping === null || isNaN(ping)) {
//             // Tidak ada koneksi atau gagal ping
//             icon.addClass("red");
//             icon.attr("title", "No Internet Access");
//             showNetworkWarning();
//         } else if (ping < 100) {
//             // Jaringan bagus
//             icon.addClass("green");
//             icon.attr("title", ping + " ms (Good)");
//             hideNetworkWarning();
//         } else if (ping < 300) {
//             // Jaringan sedang/lemah
//             icon.addClass("yellow");
//             icon.attr("title", ping + " ms (Weak)");
//             hideNetworkWarning();
//         } else {
//             // Jaringan lambat banget
//             icon.addClass("red");
//             icon.attr("title", ping + " ms (Bad)");
//             hideNetworkWarning();
//         }
//     }

//     // cek koneksi internet
//     function networkCheck() {
//         $.ajax({
//             url: "/ping",
//             method: "GET",
//             success: function (response) {
//                 const ping = response.ping ?? null;
//                 updateStatusColor(ping);
//             },
//             error: function () {
//                 updateStatusColor(null); // Gagal konek ke server
//             },
//         });
//     }

//     // tampilkan notifikasi jika tidak ada akses internet
//     function showNetworkWarning() {
//         const overlay = $("#network-overlay");
//         if (overlay.find(".network-warning").length === 0) {
//             const warningHtml = `
//             <div class="network-warning">
//                 <strong>❌ Tidak ada akses internet</strong><br>
//                 Periksa sambungan koneksi Anda untuk melanjutkan.
//             </div>
//         `;
//             overlay.removeClass("d-none").html(warningHtml);
//         }
//     }

//     // sembunyikan notifikasi jika ada akses internet
//     function hideNetworkWarning() {
//         $("#network-overlay").addClass("d-none").empty();
//     }

//     // panggil fungsi networkCheck setiap 5 detik
//     $(function () {
//         networkCheck();
//         setInterval(networkCheck, 5000); // Cek setiap 5 detik
//     });
// })();
