@extends('layout')

@section('title')
  To manage
@stop

@section('js')
<script src="/assets/js/list.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
  // Code
  var options = {
  valueNames: [ 'searchd' ]
  };

  var userList = new List('row', options);
//--------on load end-----------  
}, false);
  

</script>
@stop

@section('content')



        <a href="#" class="dl_filter_link">#W4UK</a>&nbsp;
        <a href="#" class="dl_filter_link">#APPL</a>&nbsp;
        <a href="#" class="dl_filter_link">#APPSERVER</a>&nbsp;
        <a href="#" class="dl_filter_link">#SOA</a>&nbsp;
        <a href="#" class="dl_filter_link">#AUTH</a>&nbsp;
        <a href="#" class="dl_filter_link">#NOTIF</a>&nbsp;
        <a href="#" class="dl_filter_link">#KIOSK</a>&nbsp;
        <a href="#" class="dl_filter_link">#MOBILE</a>&nbsp;
        <a href="#" class="dl_filter_link">#WEBBANK</a>&nbsp;
        <a href="#" class="dl_filter_link">#CP</a>&nbsp;
        <a href="#" class="dl_filter_link">#ECOMMERCEISS</a>&nbsp;
        <a href="#" class="dl_filter_link">#SMSB</a>&nbsp;
        <a href="#" class="dl_filter_link">#ECOMMERCEACQ</a>&nbsp;
        <a href="#" class="dl_filter_link">#WAY4IDE</a>&nbsp;
        <a href="#" class="dl_filter_link">#TSK</a><br>

        <div class="row">
          <input class="search" placeholder="Search" />
                  <div class="col-md-3">
                    <div class="list-group list" id="a_list">
                    @foreach ($CASES as $case)
                      @if($case->cat == 'A')
                        @include('partials.case_list_item')
                      @endif
                    @endforeach
                    </div>   
                  </div> 
                  
                  <div class="col-md-3">
                    <div class="list-group list"  id="b_list">
                    @foreach ($CASES as $case)
                      @if($case->cat == 'B')
                        @include('partials.case_list_item')
                      @endif
                    @endforeach
                    </div>   
                  </div> 

                  <div class="col-md-3" >
                    <div class="list-group list" id="c_list">
                    @foreach ($CASES as $case)
                      @if($case->cat == 'C')
                        @include('partials.case_list_item')

                      @endif
                    @endforeach
                    </div>   
                  </div> 

                  <div class="col-md-3"  id="d_list">
                    <div class="list-group list">
                    @foreach ($CASES as $case)
                      @if($case->cat == 'D')
                        @include('partials.case_list_item')
                      @endif
                    @endforeach
                    </div>   
                  </div> 
        </div>            
    
@stop