<!DOCTYPE html>
<html>
<head>
    <title>
      @yield('title', 'Add a title!!')
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
      .timer {
           max-width: 60px;
      }
      .done {
        display: none;
      }
    </style>

    <script src="/assets/js/jquery-2.0.3.min.js"></script>
    <script src="/assets/js/jquery.color-2.1.2.min.js"></script>
    <script src="/assets/js/jquery.autofix_anything.min.js"></script>
    <script src="/assets/js/jquery.searchabledropdown-1.0.8.src.js"></script>


      <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/assets/js/bootstrap.js"></script>    
      <!-- ZeroClipboard for copying things to clipboard --> 
    <script src="/assets/js/ZeroClipboard.js"></script>   
    <script src="/assets/js/clipboard.js"></script> 
    <!--daterange picker https://github.com/dangrossman/bootstrap-daterangepicker#readme-->
    <script src="/assets/js/moment.min.js"></script> 
    <script src="/assets/js/daterangepicker.js"></script> 
    <script src="/assets/js/shortcut.js"></script> 

    @yield('js','') 

</head>
<body>
      @yield('dialogs')
      @include('partials/navbar')      
      @yield('content')

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
     <script>
      jQuery(document).ready(function($) {
          function fillTotals(data){
            document.getElementById('today_total').innerHTML=data['today']['total'];
            document.getElementById('today_inv').innerHTML=data['today']['inv'];
            document.getElementById('week_total').innerHTML=data['week']['total'];
            document.getElementById('week_inv').innerHTML=data['week']['inv'];
            document.getElementById('month_0').innerHTML=data['month'][0]['oc'];
            document.getElementById('month_1').innerHTML=data['month'][1]['name'] + ': ' + data['month'][1]['oc'];
            document.getElementById('month_2').innerHTML=data['month'][2]['name'] + ': ' + data['month'][2]['oc'];
            document.getElementById('month_3').innerHTML=data['month'][3]['name'] + ': ' + data['month'][3]['oc'];
            document.getElementById('month_4').innerHTML=data['month'][4]['name'] + ': ' + data['month'][4]['oc'];
            document.getElementById('month_5').innerHTML=data['month'][5]['name'] + ': ' + data['month'][5]['oc'];
            document.getElementById('month_6').innerHTML=data['month'][6]['name'] + ': ' + data['month'][6]['oc'];
            document.getElementById('month_7').innerHTML=data['month'][7]['name'] + ': ' + data['month'][7]['oc'];
            document.getElementById('month_8').innerHTML=data['month'][8]['name'] + ': ' + data['month'][8]['oc'];
            document.getElementById('month_9').innerHTML=data['month'][9]['name'] + ': ' + data['month'][9]['oc'];
            document.getElementById('month_10').innerHTML=data['month'][10]['name'] + ': ' + data['month'][10]['oc'];
            document.getElementById('month_11').innerHTML=data['month'][11]['name'] + ': ' + data['month'][11]['oc'];
            document.getElementById('month_12').innerHTML=data['month'][12]['name'] + ': ' + data['month'][12]['oc'];
          }

          var fruit = 'Banana';
          // This does the ajax request
          $.ajax({
              url: '/totals',
              data: {
                  'action':'example_ajax_request',
                  'fruit' : fruit
              },
              dataType: 'json',
              success:function(data) {
                  // This outputs the result of the ajax request
                  
                  console.log(data);
                  fillTotals(data);
              },
              error: function(errorThrown){
                  console.log(errorThrown);
              }
          });
          
          $('#daterange').daterangepicker();

      });
      </script> 
      <div id="dialog_container"> </div>
    </body>
</html>