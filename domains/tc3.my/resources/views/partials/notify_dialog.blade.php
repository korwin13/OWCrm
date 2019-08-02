<div class="modal fade" id="notification_dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
      
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Отправить письмо?</h4>
         </div>

         <div class="modal-body" id="notification_dialog_content">{{@$mail_text}}</div>

         <div class="modal-footer container-fluid">
            <input type="hidden" value="{{@$notif_id}}" id="notif_id">
            <div class="col-xs-10">
               <input type="text" class="form-control" placeholder="Attachment" id="attachment"></input>
            </div>
            <div class="col-xs-1">
               <button type="button" class="btn btn-primary" id="doNotify" >Send</button>
            </div>
            <div class="col-xs-1">
               <button type="button" class="btn btn-default" id="doCancelNotify" data-dismiss="modal">Cancel</button>
            </div>
         </div>
      </div>
   </div>
</div>
