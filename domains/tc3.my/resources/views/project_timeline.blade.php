@extends('layout')

@section('js')
    <script src="/assets/js/d3.v3.min.js"></script>
    <script src="/assets/js/d3-timeline.js"></script>
    <script type="text/javascript">
        window.onload = function() {
            var testData = [ {label: "C123", times:     [{"starting_time": 1355752800000, "ending_time": 1355759900000}, 
                             {"starting_time": 1355767900000, "ending_time": 1355774400000}]},
                             {label: "C1234123", times: [{"starting_time": 1355759910000, "ending_time": 1355761900000}, ]},
                             {label: "C1234123", times: [{"starting_time": 1355761910000, "ending_time": 1355763910000}]},
                           ];
            var width = 1000;
            function timelineStackedIcons(div_id, case_timings) {
                var chart = d3.timeline()
                  .beginning({{$bday}}) // we can optionally add beginning and ending times to speed up rendering a little
                  .ending({{$eday}})
                  .stack() // toggles graph stacking
                  .margin({left:200, right:30, top:0, bottom:0})
                  .tickFormat({format: d3.time.format("%m"), 
                               tickTime: d3.time.days, 
                               tickNumber: 1, 
                               tickSize: 6 })
                  ;
                var svg = d3.select(div_id).append("svg").attr("width", width)
                  .datum(case_timings).call(chart);
            }   

            $.ajax({
              url: '/timeseries',
              data: {
                  'action':'example_ajax_request'
              },
              dataType: 'json',
              success:function(data) {
                  // This outputs the result of the ajax request            
                  timelineStackedIcons('#timeline', data);
                  timelineStackedIcons('#timeline_proj', data);
              },
              error: function(errorThrown){
                  console.log(errorThrown);
              }
            });
      }
    </script>
@stop


@section('content')
  @foreach($PROJECTS as $proj)
  <div>
    	<h3>{{$proj->code}}: {{$proj->name}}</h3>
    	<div id="{{$proj->id}}"></div>
        Status (due {{$proj->status_due}}): {{$proj->status_text}}
  </div>
@stop