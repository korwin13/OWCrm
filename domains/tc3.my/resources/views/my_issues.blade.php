@extends('layout')

@section('title')
  My Issues - {{$count}} 
@stop

@section('js')
<script>
  $(document).ready(function(){            
    var maxheight = 0;
    $("div.panel").each(function() {
      if($(this).height() > maxheight) { maxheight = $(this).height(); }
    });

    $("div.panel").height(maxheight);


    $("#doHideDone").click(function(){
        $(".done").hide();
    });
    $("#doShowDone").click(function(){
        $(".done").show();
    });

    $(".doHideSelf").click(function(){
        $(this).closest('.panel').hide();
    });
});
</script>

@stop

@section('content')
      <?php $numrows = ($count % 6) > 0 ? (floor($count/6) + 1) : $count/6; ?>
      @for($j = 0; $j <= $numrows; $j++)
          <div class="container" style="width:100%">
            <div class="row">
            @for ($i = 0; $i < 6; $i++)
                @if($j*6 + $i < $count)
                    <? $case = $CASES[$j*6 + $i]?>
                    <div class="col-md-2">
                        @include('partials.case_summary_panel')
                    </div>
                @endif
            @endfor
            </div>
          </div>
      @endfor
@stop