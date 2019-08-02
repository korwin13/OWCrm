	<div class="jumbotron">
 
     <h3>{{$CASE->record_idt}}</h2>
     <h4>{{$CASE->cust_name}}  ({{$CASE->fax_number}})</h4> 
     <p>{{$CASE->name}}</p>
     <p>Remain time: {{$CASE->remain_time}} d</p> 
     <p>Last updated: ago</p>
     <p>Assignee: {{$CASE->officer_name}}</p>
     <p>Used time: {{$CASE->used_time}}h</p>
     <p>Result details: {{$CASE->result_details}}</p>
		<div class="panel panel-default">
		  <div class="panel-heading">
		    <h4 class="panel-title">
		      <a data-toggle="collapse" href="#">
		        Full info
		      </a>
		    </h4>
		  </div>
		  {{var_dump($CASE)}}
		</div>
</div>
