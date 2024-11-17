

<!doctype html>
<html
  lang="en"
  class="light-style layout-wide customizer-hide"
   dir="rtl"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
  data-style="light">
  <head>
  @include('auth.layouts.head')

  </head>

  <body>

    <!-- Content -->

    @yield('content')

    <!-- / Content -->


  </body>
  @include('auth.layouts.script')
</html>



