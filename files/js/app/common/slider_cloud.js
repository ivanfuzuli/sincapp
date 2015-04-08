define(['jquery', 'plugins/jquery.flexslider'], function($, bx) {
   var elements = new Array();
   var clicked = false;
   return {
       init: function(){ 
        $('.flexslider').addClass('flex-active').flexslider();
       }
   }
});