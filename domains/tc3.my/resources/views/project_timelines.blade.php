@extends('test_layout')

@section('js')
<style type="text/css">
    .axis path,
    .axis line {
      fill: none;
      stroke: black;
      shape-rendering: crispEdges;
    }

    .axis text {
      font-family: sans-serif;
      font-size: 10px;
    }

    .timeline-label {
      font-family: sans-serif;
      font-size: 12px;
    }
    
    #timeline2 .axis {
      transform: translate(0px,30px);
      -ms-transform: translate(0px,30px); /* IE 9 */
      -webkit-transform: translate(0px,30px); /* Safari and Chrome */
      -o-transform: translate(0px,30px); /* Opera */
      -moz-transform: translate(0px,30px); /* Firefox */
    }

    .coloredDiv {
      height:20px; width:20px; float:left;
    }
  </style>
 <script src="/assets/js/d3.v3.min.js"></script>
 <script src="/assets/js/d3-timeline.js"></script>

    <script type="text/javascript">
        window.onload = function() {
            var width = 1300;
            function timelineStackedIcons(div_id, case_timings) {
                 //https://github.com/jiahuang/d3-timeline
                var chart = d3.timeline()
                  .showToday()
                  .showTodayFormat({marginTop: 5, marginBottom: 5, width: 10, color: "red"})
                  .beginning({{$bday}}) // we can optionally add beginning and ending times to speed up rendering a little
                  .ending({{$eday}})
                  .stack() // toggles graph stacking
                  .margin({left:400, right:30, top:0, bottom:0})
                  .tickFormat({format: d3.time.format("%b-%d"), 
                               tickTime: d3.time.days, 
                               tickInterval: 5, 
                               tickSize: 6 })
                  ;
                var svg = d3.select(div_id).append("svg").attr("width", width)
                  .datum(case_timings).call(chart);
            }   

            @foreach($PROJECTS as $prj)
              data_{{$prj['P']->id}} = {{json_encode($prj['TS'])}};
              timelineStackedIcons("#{{$prj['P']->code}}", data_{{$prj['P']->id}});
            @endforeach
            
            
      }
    </script>
@stop


@section('content')

  @foreach($PROJECTS as $prj)
   <div>
        <h3>{{$prj['P']->code}}: {{$prj['P']->name}}</h3>
        <div id="{{$prj['P']->code}}"></div>
  </div>
  @endforeach
@stop