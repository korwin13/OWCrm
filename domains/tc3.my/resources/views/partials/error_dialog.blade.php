<div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
         <h4 class="modal-title" id="myModalLabel">Error</h4>
       </div>
       <div class="modal-body" id="error_contents">

            {{$err_text}}
   
       </div>
       <div class="modal-footer">
         <input type="hidden" value="{{$id}}" id="iss_id">
         <button type="button" class="btn btn-primary" id="doErrOk" >OK</button>
   </div>