      <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
         <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body" id="save_dialog_content">
         <ul class="list-group">@foreach ($attachments as $attachment)
            <li class="list-group-item">{{$attachment->direction}} 
               @if(strpos($attachment->document, ".txt"))
                  <a href="file:\\\{{$p_path}}\{{$attachment->document}}">{{$attachment->document}}</a>
               @else
                {{$attachment->document}}
               @endif
            </li>@endforeach
         </ul>
         <div id="res">cd {{$p_path}}</div>(click to copy)
         <span id="saved" class="glyphicon glyphicon-ok hidden">Saved</span>
      </div>
      <div class="modal-footer">
         <input type="hidden" value="{{$id}}" id="iss_id">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="doSave" >Save on P</button>
      </div>
   