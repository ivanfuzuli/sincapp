define(['jquery'], function(jQuery){

/*
 * 2012 canBar Can Kucukyilmaz
 **/

(function($) {
   var toastPar = '<div id="toastPar"></div>';

   this.init = function(){
       $('body').append(toastPar);

   }();   
    $.canToast = $.fn.canToast = function(content) {
        var closeBut = $('<div />').addClass('closeToast');
        var html = $('<div />').addClass('canToast').append(closeBut).append(content).hide().fadeIn();
        
        $('#toastPar').append(html);
        
         setTimeout(function(){
           html.slideUp(function(){$(this).remove()});  
         } ,5000);
         
         closeBut.click(function(){
            html.slideUp(function(){$(this).remove()});  
            
         });
    }

}(jQuery));
});