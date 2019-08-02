@extends('layout')

@section('js')
<script src="/assets/js/list.fuzzysearch.min.js"></script>
@stop

@section('content')

        <div class="row">
        <div class="col-md-4">
          <br>
	        <div class="list-group">
	             @foreach ($CASES as $case)
      			       @if ($case->record_idt == $curr_idt)
            					<a href="{{url('manage', array($case->record_idt))}}" class="list-group-item active">
      			       @else
					            <a href="{{url('manage', array($case->record_idt))}}" class="list-group-item">
				           @endif      			
					         <div class='block2' style="float:right">
          						@if($case->used_time == 0)
          							<span class="label label-warning">{{number_format($case->used_time, 2)}}</span>
          						@else
          							<span class="label">{{number_format($case->used_time, 2)}}</span>
          						@endif
					         </div>
	    			       <h4 class="list-group-item-heading">{{$case->open_date}} | {{$case->cust_name}}</h4>
	    			       <p class="list-group-item-text">{{$case->name}}</p>
	  				          </a>
		           @endforeach
    	  	</div>
        </div>
        <div class="col-md-8">
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
@stop