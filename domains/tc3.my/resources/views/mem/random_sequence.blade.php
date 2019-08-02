@extends('mem/mem_layout')

@section('title')
Random sequence
@stop

@section('js')

<script src="/assets/js/jquery-2.0.3.min.js"></script>
<script type="text/javascript">
    //slideshow
    //show arbitrary elem on btn click change
    var current = 0;


    function getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    function pad(n) {
        return (n < 10) ? ("0" + n) : n;
    }

    function generateRandomStr(lim) {
        var str = '';
        //var lim = 20;
        for (var i=0;i<=20;i++) {
            str += pad(getRandomInt(1, lim)) + '&nbsp;&nbsp;';
        }
        return str;
    }
    function showRandomStr() {
        var str = '';
        var lim = 40;
        for(var i=1;i<=4;i++){  
            str = generateRandomStr(lim);
            //console.log(str);  
            $('#str'+i).html( str );
        } 
    }

    var d = document;

    //d.addEventListener("DOMContentLoaded", nextCard, false);

    showRandomStr();   

</script>


@stop

@section('content')



<div class="row">
    <div class="col-md-12">
        <h1 class="text-center" id="str1">!work</h1>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h1 class="text-center" id="str2">!work</h1>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h1 class="text-center" id="str3">!work</h1>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h1 class="text-center" id="str4">!work</h1>
    </div>
</div>



@stop