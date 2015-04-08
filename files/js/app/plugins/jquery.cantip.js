define(['jquery'], function(jQuery){

(function($) {
var content = '<div id="canTip"><div id="tipArrow"></div><div id="tipContent"></div></div>';    
   
   this.init = function(){ 
        
        $(document).ready(function(){
            $('body').append(content);
        });

   }();
   
$.fn.canTip = function(options) {
    options = $.extend({
        //kutu icerigi
        html: null
    
}, options);
   
        var selElm = this.selector;//
        function start(elem) {
                if(elem.hasClass('ui-draggable-dragging')){//.mergeMe moving bug fixe
                  return;
                }
       
              //tip boxin icerigini ayarlayalim
              $('#tipContent').html(options.html);
              //icerigin boyutunun ortalamasi, ana elementle birlesip boyutu ortalamak icin
              var tipW1 = $('#canTip').innerWidth();
              var tipW = Math.round(tipW1/2);
              var width = Math.round(elem.width()/2);

              //offset bilgileri
              var offs = elem.offset();
              var left = offs.left;
              var height = elem.innerHeight();
              
              
              var newTop = offs.top + height + 5;
              var newLeft = left - tipW + width;
              var backPos = tipW - 8;
              //tamamen soldan cikmasi durumunda
              if(newLeft < 0){
                  newLeft = 0;
                  backPos = 8;
              }else{
                  
              }
              
              $('#canTip').css({'left': newLeft, 'top': newTop});
              $('#tipArrow').css({ 'marginLeft':backPos});
              $('#canTip').show();

        };
            $('body').on('mouseover.cantip', selElm, function(e){
              start($(this));
        });
        $('body').on('mouseleave.cantip', selElm, function(){
           $('#canTip').hide(); 
           $('#tipArrow').css({ 'marginLeft':0});
        });
         $('body').on('click.cantip', selElm, function(){
           $('#canTip').hide(); 
           $('#tipArrow').css({ 'marginLeft':0});
        });   
         $('body').on('dblclick.cantip', selElm, function(){
          start($(this));
          $('#canTip').effect('bounce');
        });  


   }
}(jQuery));
});