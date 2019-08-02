@extends('mem/mem_layout')

@section('title')
	testpage 
@stop

@section('js')
      <link href="/assets/css/bootstrap.css" rel="stylesheet" media="screen">
      <script src="/assets/js/ZeroClipboard.js"></script>
      <script src="/assets/js/shortcut.js"></script>
      <script src="/assets/js/bootstrap.js"></script>

      <!-- Save on P dialog handler-->
      <script type="text/javascript">
      $(function(){
               function completeIssue(iss_id) {
                         //get data of exact uncompleted issue
                  var token = $('#_token').val();
                  console.log("token: " + token);
                  $.ajax({
                  //type: 'get',
                  cache: false,
                  //headers: { 'X-XSRF-TOKEN' : token }, 
                  url: '/test_dialog',
                  //contentType: "application/json; charset=utf-8",
                  dataType: 'html',
                  data: {test: 'test'}, 
                  success: function(datan) 
                  {
                     console.log(datan);
                     $('#dialog_container').html(datan);
                     $('#notification_dialog').modal('show');
                  }});
               }

               function completeIssue2() {
                  $('#notification_dialog').modal({
                                show: true,
                                remote: "/test_dialog"
                            });

               }

               function completeIssue3() {
                     $('#dialog_container').load('/test_dialog', {test: 'test'}, function(){
                           $('#notification_dialog').modal('show');
                     });
                     //$('#notification_dialog').modal('handleUpdate');
                     $('#notification_dialog').on('loaded.bs.modal', function (e) {
                  });
               }

         shortcut.add("Ctrl+Enter", function() { completeIssue(); });   
      });


      </script>
@stop


@section('content')
     <!-- Modal -->

     <div id="dialog_container"> </div>
     



    <div class="row">
        <div class="col-md-4">
          
        </div>
        <div class="col-md-8">
			<div class="btn-group">
			  <button type="button" class="btn btn-default doComplete" id="complete_4549764">Complete</button>
			  <button type="button" class="btn btn-default">Attach</button>
			  <button type="button" class="btn btn-default">ClAdvice</button>
        <button type="button" class="btn btn-default doReclassify" id="reclassify_4549764">Reclassify</button>
			</div>

      <input type="hidden" value="{{ $encrypted_token }}" id="_token" >  
        <input type="hidden" value="4549764" name="iss_id">
        <div class="btn-group pull-right" data-toggle="buttons">
                 <label class="btn btn-default">
                    <input type="radio" id="time0" name="timing_4549764" checked="checked" value="0.0" /> 0m
                </label> 
                <label class="btn btn-default active" >
                    <input type="radio" id="time1" name="timing_4549764" value="0.017" /> 1m
                </label> 
                <label class="btn btn-default">
                    <input type="radio" id="time2" name="timing_4549764" value="0.034" /> 2m
                </label> 
                <label class="btn btn-default">
                    <input type="radio" id="time3" name="timing_4549764" value="0.05" /> 3m
                </label> 
                <label class="btn btn-default">
                    <input type="radio" id="time4" name="timing_4549764" value="0.07" /> 4m
                </label> 
                <label class="btn btn-default">
                    <input type="radio" id="time5" name="timing_4549764" value="0.1" /> 5m
                </label>
                <label class="btn btn-default">
                    <input type="radio" id="time5" name="timing_4549764" value="0.2" /> 10m
                </label>
            
          </div>
        </div>              
    </div>

@stop
