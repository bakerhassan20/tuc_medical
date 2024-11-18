<!doctype html>

<html

  lang="en"
  class="light-style layout-menu-fixed layout-compact"
   dir="rtl"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
  data-style="light">

<head>

    @yield('head')
    @include('layouts.head')

</head>
<!-- END: Head -->

<body>

  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">

            <!-- Menu -->
            @include('layouts.menu')
            <!-- / Menu -->

        <!-- Layout container -->
          <div class="layout-page">
              <!-- Navbar -->
              @include('layouts.nav')
              <!-- / Navbar -->

      <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
              @yield('content')
            <!-- / Content -->

              <!-- Footer -->
          @include('layouts.footer')
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
        </div>
       <!-- Content wrapper -->
    </div>
        <!-- / Layout page -->
  </div>
  </div>
      <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->



    @include('layouts.models')


    @include('layouts.script')
    @yield('script')

</body>

</html>
