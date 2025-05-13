<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <x-link class="navbar-brand ps-3 text-uppercase app_title" url="/home" label="{{ config('app.name') }}" />
    <button class="btn btn-link btn-sm order-1 order-lg-0 ms-auto ms-md-0 me-3 me-lg-4" id="sidebarToggle"
        href="#!"><i class="fas fa-bars"></i></button>
    <div class="navbar-nav ms-auto me-3 me-lg-4 ms-lg-auto d-block text-center">
        <div class="text-white" id="clock"></div>
        <div class="text-white d-none d-lg-block" id="dates"></div>
    </div>
</nav>
