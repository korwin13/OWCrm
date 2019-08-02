@extends('layout')

@section('title')
  {{$CASE->cust_name}}.&nbsp;{{$CASE->name}} 
@stop

@section('js')
      <script src="/assets/js/ZeroClipboard.js"></script>
      <script type="text/javascript" src="/assets/js/shortcut.js"></script>

      <!-- Save on P dialog handler-->
      <script type="text/javascript">
      //window.onbeforeunload = function() { return "You work will be lost."; };
      $(function(){
          var token = $('#token').val();

         $('#save_dialog').on('loaded.bs.modal', function (e) {
            //initiate saving attachments to p
            $('#doSave').click(function(event){
               var iss_id = $('#iss_id').val();
               $.get( "/saveonp/"+iss_id, function( data ) {
                  $( "#saved").removeClass("hidden");
               });
            });
            //Copy p path to clipboard 
            var client = new ZeroClipboard( document.getElementById("doSave") );
            client.on( "ready", function( readyEvent ) {
                client.on( "copy", function (event) {
                  var clipboard = event.clipboardData;
                  var text = $("#res").html();

                  clipboard.setData( "text/plain", text );
                });

                client.on( "aftercopy", function( event ) {
                  // `this` === `client`
                  // `event.target` === the element that was clicked
                  //event.target.style.display = "none";
                  //alert("Copied text to clipboard: " + event.data["text/plain"] );
                } );

            } );
         });

         $('#save_dialog').on('hidden.bs.modal', function() {
            $(this).data('bs.modal').$element.removeData();
         });

        function completeIssue(iss_id) {
                         //get data of exact uncompleted issue

                var iss_text = $("#iss_text_" + iss_id).val();
                var timing =   $('input[name="timing_' + iss_id + '"]:checked').val();
                var iss_comment =  $("#iss_comment_"+ iss_id).val();
                var iss_attachment_path = $("#iss_att_path_" + iss_id).val();
                
                //console.log("token: " + token);
                //console.log("iss_id: " + iss_id);
                //console.log("new text: " + iss_text);
                //console.log("new time: " + timing);
                console.log("attachment: " + iss_attachment_path);
                if (iss_id) {  
                    $.ajax({
                    type: 'post',
                    cache: false,
                    headers: { 'X-XSRF-TOKEN' : token }, 
                    url: '/issue_complete/'+iss_id+'/update',
                    //contentType: "application/json; charset=utf-8",
                    dataType: 'html',
                    data: {text: iss_text, comment: iss_comment, new_time: timing, attachment: iss_attachment_path}, 
                    success: function(data) {
                            console.log("doComplete update result:" + data);
                            if (data.indexOf("OK") > -1) {
                              console.log("Inner iss_id:" + iss_id);
                              $.ajax({
                                    url: "/issue_complete/"+iss_id+"/complete",
                                    headers: { 'X-XSRF-TOKEN' : token },   
                                    //dataType: 'html',   
                                    success: function(datan) {
                                        //console.log(datan);
                                        $('#dialog_container').html(datan);
                                        $('#doNotify').click(function(event){
                                            
                                            var notif_id = $('#notif_id').val();
                                            console.log('Notif_id from notify dialog: ' + notif_id)
                                            $.get( "/issue_complete/"+notif_id+"/notify", function( data ) {
                                                $('#notification_dialog').modal('hide'); 
                                                console.log(data);
                                            });
                                        }); 

                                        $('#doCancelNotify').click( function(event) {
                                          var notif_id = $('#notif_id').val();
                                          console.log('Going to remove notification' + notif_id);   
                                          $.get( "/issue_complete/"+notif_id+"/cancel", function( data ) {
                                                $('#notification_dialog').modal('hide'); 
                                                console.log(data);
                                          });
                                        })

                                        $('#notification_dialog').modal();
                                      }});
                            }       
                            else {
                              alert(data);     
                            }
                    }}); //end ajax
                } 
        }

         $(".doComplete").click(function() {
            //get data of exact uncompleted issue
            var t = $(this); //pointer to clicked button, required for blinking (see below)
            var p = t.attr('id');
            var iss_id = p.split('_')[1];

            var iss_text = $("#iss_text_" + iss_id).val();
            //use manually input time or one of radiobuttons-selected time
            var timing = $('input:text[name="timing_' + iss_id + '"]').val() ? $('input:text[name="timing_' + iss_id + '"]').val() : $('input[name="timing_' + iss_id + '"]:checked').val();
            var iss_comment =  $("#iss_comment_"+ iss_id).val();
            var iss_attachment_path = $("#iss_att_path_" + iss_id).val();
            var issueData = {text: iss_text, comment: iss_comment, new_time: timing, attachment: iss_attachment_path};

            //console.log("token: " + token);
            console.log(issueData);

               completeIssue(iss_id);
            //saveIssueData(iss_id, issueData, function(data) {
            //   console.log('iss_id: '+iss_id+' | saveIssueData result:' + data);
            //}); //issue save
         });


         function saveIssueData (iss_id, fields, whenDone) {
            $.ajax({
               type: 'post',
               cache: false,
               headers: { 'X-XSRF-TOKEN' : token }, 
               url: '/issue_complete/'+iss_id+'/update',
               //contentType: "application/json; charset=utf-8",
               dataType: 'html',
               data: fields, 
               success: whenDone
            });
         }



         $(".doSave").click(function(){
            //get data of exact uncompleted issue
            var t = $(this); //pointer to clicked button, required for blinking (see below)
            var p = t.attr('id');
            var iss_id = p.split('_')[1];

            var iss_text = $("#iss_text_" + iss_id).val();
            //use manually input time or one of radiobuttons-selected time
            var timing = $('input:text[name="timing_' + iss_id + '"]').val() ? $('input:text[name="timing_' + iss_id + '"]').val() : $('input[name="timing_' + iss_id + '"]:checked').val();
            var iss_comment =  $("#iss_comment_"+ iss_id).val();
            var iss_attachment_path = $("#iss_att_path_" + iss_id).val();
            var issueData = {text: iss_text, comment: iss_comment, new_time: timing, attachment: iss_attachment_path, check_flag: 1 };

            console.log("token: " + token);
            console.log(issueData);

            saveIssueData(iss_id, issueData, function(data) {
               console.log('iss_id: '+iss_id+' | saveIssueData result:' + data);
               var dur = 500; 
               if (data[0] == 'I') { //OK-case
                  //blink green 
                  t.closest('.panel-footer').animate({ backgroundColor: jQuery.Color("#90EE90")  }, dur ).animate({ backgroundColor: jQuery.Color("rgb(245,245,245)")  }, dur );
               } else { 
                  //blink red  
                  t.closest('.panel-footer').animate({ backgroundColor: jQuery.Color("red")  }, dur ).animate({ backgroundColor: jQuery.Color("rgb(245,245,245)")  }, dur );
               }
            }); //issue save
         });

        $("#doHideDone").click(function(){
            $(".done").hide();
        });
        $("#doShowDone").click(function(){
            $(".done").show();
        });



        $('#notification_dialog').on('loaded.bs.modal', function (e) {


        });

        $('#notification_dialog').on('hidden.bs.modal', function (e) {
            //update issue partial
            //flash-sending
            //alert('sent');
        });     

        $('#new_jira').click(function(){
            window.open("https://ows-jira/secure/CreateIssue!default.jspa");
        });

        $(".done").show();    

        $(".jiralink").each(function(){
          
          var new_elem = $(this).clone();
          var mentions = $('#jiralinks');
          var mentions_text = $('#jiralinks').text()
          var candidate_text = new_elem.text();
          if(mentions_text.length == 0){
            mentions.append(new_elem);
          }
          if( mentions.text().indexOf(candidate_text) == -1) {
            mentions.append(new_elem);
          }
        });

      });


      shortcut.add("Ctrl+Enter",function()
      {
        //get current edit_field
        var cur_textf = $(':focus');
        //emulate click on Complete
        if(cur_textf.attr('class') == 'iss_text') {
          cur_textf.parent().find('.doComplete').click();
        }

        //execute click on appropriate $(".doComplete")
      });
      shortcut.add("Ctrl+1",function()
      {
        //get current edit_field
        var cur_textf = $(':focus');
        if(cur_textf.attr('class') == 'iss_text') {
          alert('set radio to 1');  
          
        }
      });
      </script>
@stop

@section('dialogs')
     <!-- Modal -->
    <div class="modal fade" id="save_dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg">
          <div class="modal-content">...</div>
       </div>
    </div>   
@stop


@section('content')
           <div class="row">
        <div class="col-md-4">
            @include('partials.case_summary_jumb')
        </div>
        <div class="col-md-8">
            <input type="hidden" value="{{ $encrypted_token }}" id="token" >
            <div style='white-space:nowrap;'>JIRA Mentions: <div style='display:inline-block;' id='jiralinks'></div></div><br> 
            <!-- email stream area start-->
              @if (isset($SEQ))
                <div class="panel-group" id="accordion">  
                @foreach ($SEQ as $issue)
                  @include('partials.issue')
                @endforeach
                </div>
              @endif
            <!-- email stream area end -->
            </div>              
            
          </div>
        </div>
      </div>
@stop
