<meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Demo : Dashboard - Analytics | sneat - Bootstrap Dashboard PRO</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />


        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

           <!-- Boxicons CSS -->
           <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

        <!-- Core CSS -->
        <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

        <!-- Vendors CSS -->
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

        <!-- Page CSS -->
        <!-- Page -->
        <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />

        <!-- Helpers -->
        <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

        <!-- Template customizer & Theme config files -->
        <script src="{{ asset('assets/js/config.js') }}"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>


 <script>
    @auth
   var JSvar = "<?= Auth::user()->id?>";
    @endauth
       // Enable pusher logging - don't include this in production
       Pusher.logToConsole = true;

       var pusher = new Pusher('781f8f90926b7f8f25f4', {
         cluster: 'ap2'
       });

       var channel = pusher.subscribe('status-liked');
       channel.bind('noyify', function(data) {
        
           if(data.username == JSvar && data.message == 'book'){
           $("#notifications_count").load(window.location.href + " #notifications_count");
            $.get(window.location.href, function(response) {
               var updatedContent = $(response).find('#unread').html();

               // Update the #unread div with the fetched content
               $("#unread").html(updatedContent);

             });
           }else{

           }


       });



     </script>
