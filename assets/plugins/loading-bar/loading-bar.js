function cargarGif(){
  var progress = new LoadingOverlayProgress({
    bar     : {
      "background"    : "#337ab7",        
      "height"        : "15px",
      "border-radius" : "15px"
    },
    text    : {
      "color"         : "#fff",
      "font-family"   : "monospace",
    }
  });

  $.LoadingOverlay("show", {
    custom  : progress.Init(),
    fade  : [1000, 2000],
    color           : "rgba(0,0,0,0.9)",
    image           : "http://www.developers.ec/loading-bar.gif",
    maxSize         : "400px",
    minSize         : "400px",
   });

  var count     = 0;
  var interval  = setInterval(function(){
    if (count >= 100) {
        clearInterval(interval);
        delete progress;
       
        return;
    }
    count++;
    progress.Update(count);
    }, 10)
}

function cerrarGif(){
  $.LoadingOverlay("hide");
}