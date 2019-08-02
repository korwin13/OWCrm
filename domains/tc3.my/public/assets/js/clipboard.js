//copy link to P:\ to clipboard
$(document).ready(function(){
   ZeroClipboard.config( { swfPath: "/assets/js/ZeroClipboard.swf" } );
   var p = new ZeroClipboard( $("#doSave"));
   //????????????
   p.on("ready", function(event) {
      console.log("tadam");
      ZeroClipboard.setData( "text/plain", "Copy me!" );
   });
});


   //TODO: copy issue idt to clipboard



