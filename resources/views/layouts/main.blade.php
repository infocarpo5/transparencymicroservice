<!-- start header-->
@include('layouts.header')
<!-- end header-->

<body class="g-sidenav-show  bg-gray-100">
    <!--  start aside-->
    @yield('sidebar')

    @include('layouts.aside')
    <!--  end aside-->
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('layouts.nav-bar')
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <!--start content-->
            @yield('contents')
            <!--end content-->

            <!-- start footer-->
            @include('layouts.footer')
            <!--end footer-->
        </div>
    </main>
    <!-- start fixed plugins-->

    @include('layouts.fixed-plugins')
    <!-- end fixed plugins-->

    <!-- start footer script-->
    @include('layouts.footer-script')
    <!-- end footer script-->
    @yield('scripts')

</body>

</html>
