@if($case->on_our_side == 'N')
    {{-- this is  a ping --}}
    <div class="panel panel-green done">
    <div class="panel-heading">
@elseif($case->remain_time < 0 )
    <div class="panel panel-danger">
    <div class="panel-heading">
@elseif($case->remain_time < 5 ) 
    <div class="panel panel-info">
    <div class="panel-heading">
@elseif($case->project) 
	<div class="panel panel-warning">
    <div class="panel-heading">
@else 
	<div class="panel panel-default">
    <div class="panel-body">
@endif
     <h3><a href="/case/{{$case->record_idt}}">{{$case->record_idt}}</a></h2>
     <h4 class="cust_name">{{$case->cust_name}}</h4>
     <p class="case_name">{{strlen($case->name) > 70 ? substr($case->name, 0, 70)."..." : $case->name}}</p>
     <p>Remain time: {{$case->remain_time}}d</p> 
     <p>Used time: {{$case->used_time}}h</p>
     <p><button type="button" class="btn btn-primary btn-sm doHideSelf" id="doHideCase_{{$case->record_idt}}" data-clipboard-text="Copy me!">Hide it!</button></p>
  </div>
</div>