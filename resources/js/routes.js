const path = new URL(window.location.href).pathname;
const routes = {
    "/login": () => import("@/partials/showPassword.js"),
    "/barang/": () => import("@/partials/Barang.js"),
    "/pelanggan/": () => import("@/partials/Pelanggan.js"),
    "/supplier/": () => import("@/partials/Supplier.js"),
    "/stok/": () => import("@/partials/Stok.js"),
    "/receiving/": () => import("@/partials/BarangMasuk.js"),
};
for (const route in routes) {
    // Cocokkan dengan semua variasi jika menggunakan method startwith
    if (path.startsWith(route)) {
        routes[route]().then((module) => {
            const parameters = path.split("/").pop(); // get parameter url
            module.default(parameters);
        });
        break;
    }
}
