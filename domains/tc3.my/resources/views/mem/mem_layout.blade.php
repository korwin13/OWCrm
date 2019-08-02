<!DOCTYPE html>
<html>
<head>
    <title>
      @yield('title', 'Memory cards')
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
    <!-- Bootstrap -->
    <link href="/assets/css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="/assets/css/autofix_anything.css" rel="stylesheet" media="screen">

    <link href="/assets/css/daterangepicker-bs3.css" rel="stylesheet" media="all">

    <style type="text/css">
      .panel-green {
           background-color: springgreen;
      }
    </style>

    <script src="/assets/js/jquery-2.0.3.min.js"></script>
    <script src="/assets/js/jquery.autofix_anything.min.js"></script>
    <script src="/assets/js/jquery.searchabledropdown-1.0.8.src.js"></script>


      <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/assets/js/bootstrap.js"></script>    
      <!-- ZeroClipboard for copying things to clipboard --> 
    <script src="/assets/js/ZeroClipboard.js"></script>   
    <script src="/assets/js/clipboard.js"></script> 


</style>
</head>
<body>

      @include('mem/mem_navbar')       
      @yield('content')
    @yield('js','') 

      <!--script type="text/javascript">       
      $(document).ready(function() {
          $(document).scroll(function(){
              var elem = $('.navbar');
              if (!elem.attr('data-top')) {
                  var offset = elem.offset()
                  elem.attr('data-top', offset.top);
              }
              if (elem.attr('data-top') < $(this).scrollTop() )
                  elem.addClass('navbar-fixed-top');
              else
                  elem.removeClass('navbar-fixed-top');
          }); 
      });
      </script -->

    </body>
</html>