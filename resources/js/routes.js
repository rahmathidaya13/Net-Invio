const path = new URL(window.location.href).pathname;
const routes = {
    "/login": () => import("@/partials/showPassword.js"),
}
for (const route in routes) {
    // Cocokkan dengan semua variasi jika menggunakan method startwith
    if (path.startsWith(route)) {
        routes[route]().then((module) => {
            module.default();
        });
        break;
    }
}
