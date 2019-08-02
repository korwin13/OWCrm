@extends('layout')

@section('title')
  Lenta - {{$count}} 
@stop

@section('js')
<script>
  $(document).ready(function(){            
    var maxheight = 0;
    $("div.panel").each(function() {
      if($(this).height() > maxheight) { maxheight = $(this).height(); }
    });

    $("div.panel").height(maxheight);
});
</script>

@stop

@section('content')
      <?php 
      $new_row = -1;
      $prev_off = "";
      ?>
      @for($i = 0; $i < $count; $i++)
          
          <?php   
            if ($prev_off != $CASES[$i]->officer_name and $new_row !=-1) {
                $new_row = 1;
            } 
            if ($prev_off == $CASES[$i]->officer_name and $new_row !=-1) {
                $new_row = 0;
            }
            $prev_off = $CASES[$i]->officer_name;
          ?>  

          @if ($new_row == 1)
            </div><div class="row">
            {{$prev_off}}
          @elseif ($new_row == -1)
            <div class="row">
          @endif
            <div class="col-md-2">
                      <? $case = $CASES[$i]?>
                      @include('partials.case_summary_panel')
            </div>          
      @endfor
      </div>
@stop