<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <x-link class="navbar-brand ps-3 text-uppercase app_title" url="/home" label="{{ config('app.name') }}" />
    <button class="btn btn-link btn-sm order-1 order-lg-0 ms-0 ms-md-0 me-0 me-lg-4" id="sidebarToggle"
        href="#!"><i class="fas fa-bars"></i></button>
    <div class="navbar-nav ms-auto me-2 me-lg-4 ms-lg-auto d-lg-block text-center ">
        <div class="text-white order-2" id="clock"></div>
        <div class="text-white order-1 d-lg-none" id="days"></div>
        <div class="text-white d-none d-lg-block" id="dates"></div>
    </div>
</nav>
