         @if ($case->record_idt == $curr_idt)
            <a href="{{url('case', array($case->record_idt))}}" class="list-group-item active">
         @else
            <a href="{{url('case', array($case->record_idt))}}" class="list-group-item">
         @endif           
         <div class='block2' style="float:right">
            @if($case->used_time == 0)
              <span class="label label-warning">{{number_format($case->used_time, 2)}}</span>
            @else
              <span class="label">{{number_format($case->used_time, 2)}}</span>
            @endif
         </div>
         <h4 class="list-group-item-heading searchd">{{$case->open_date}} | {{$case->cust_name}} | {{$case->dl_code}} </h4>
         <p class="list-group-item-text">{{$case->name}}</p>
            </a>