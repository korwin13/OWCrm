@extends('layout')


@section('content')

      <div class="row">
        <div class="col-md-4">
            <div class="jumbotron">            
              <h2>Filter:</h2>
              <p>Text</p>
              <p>Date</p>
              <p>Customer</p>
              <p>Officer</p>
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
        </div>
      </div>
@stop
