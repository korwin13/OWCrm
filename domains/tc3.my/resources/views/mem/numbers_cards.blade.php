@extends('mem/mem_layout')

@section('js')

<script type="text/javascript" src="/assets/js/shortcut.js"></script>
<script type="text/javascript">
    //slideshow
    //show arbitrary elem on btn click change
    var current = 0;

    function showN(n) {
        current = n;
        document.card1.src='/assets/img/MemCards/Underside/00-99/' + pad(current) + '-1.jpg';
    }

    function getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    function pad(n) {
        return (n < 10) ? ("0" + n) : n;
    }

    function nextCard() {
        current += 1;
        showN(current);
    }

    function prevCard() {
        current > 0 ? current -= 1 : current = 0;
        showN(current);
    }

    function showRandom(n) {
        current = getRandomInt(1, n);
        showN(current);    
    }

    function showFront() {
        document.card1.src='/assets/img/MemCards/Underside/00-99/' + pad(current) + '-1.jpg';
    }

    function showBack() {
        document.card1.src='/assets/img/MemCards/Card/00-99/' + pad(current) + '.jpg';
    }

    var d = document;

    //d.addEventListener("DOMContentLoaded", nextCard, false);

    shortcut.add("0", function() { showN(2); });   
    shortcut.add("1", function() { showN(1); });   
    shortcut.add("2", function() { showN(2); });   
    shortcut.add("3", function() { showN(3); });   
    shortcut.add("4", function() { showN(4); });   
    shortcut.add("5", function() { showN(5); });   
    shortcut.add("6", function() { showN(6); });   
    shortcut.add("7", function() { showN(7); });   
    shortcut.add("8", function() { showN(8); });   
    shortcut.add("9", function() { showN(9); });   
    shortcut.add("Right", function() { nextCard(); });   
    shortcut.add("Left", function() { prevCard(); });   
    shortcut.add("Space", function() { showRandom(50); });   



</script>


@stop

@section('content')



<div class="row">
    <div class="col-md-4"></div>    
    <div class="col-md-4">
        <a href="#" onMouseOut=showFront() 
                   onMouseOver=showBack()>
            <img name="card1" src="\assets\img\MemCards\Underside\00-99\00-1.jpg" border="0" />
        </a>
    </div>    
    <div class="col-md-4"></div>    
</div>
<div class="row">
    <div class="col-md-4"></div>    
    <div class="col-md-4">
         <div class="wrapper text-center">
             <div class="btn-group center-block" role="group" aria-label="...">
                       <button type="button" class="btn btn-default" id="showPrev" onClick=prevCard()><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span></button>
                       <button type="button" class="btn btn-default" id="showNext" onClick=nextCard()><span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></button>
                       <button type="button" class="btn btn-default" id="show10" onClick=showN(1)>01</button>
                       <button type="button" class="btn btn-default" id="show10" onClick=showN(10)>10</button>
                       <button type="button" class="btn btn-default" id="show20" onClick=showN(20)>20</button>
                       <button type="button" class="btn btn-default" id="show20" onClick=showN(30)>30</button>
                       <button type="button" class="btn btn-default" id="show20" onClick=showN(40)>40</button>
                       <button type="button" class="btn btn-default" id="show20" onClick=showN(50)>50</button>
                       <button type="button" class="btn btn-default" id="showRandom" onclick=showRandom(50)>Random(50)</button>
             </div>
         </div>
    </div>    
    <div class="col-md-4"></div>    
</div>



@stop