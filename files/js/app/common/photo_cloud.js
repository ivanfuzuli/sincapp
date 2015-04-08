define(['jquery', 'plugins/jquery.colorbox-min'], function($) {
   return {
       init: function(){
                this.light();
       },
       
       binder: function(){
             $('body').on('click', '.thumbPhoto a', function(){
                 $(this).colorbox({rel:'group1'});
             })
          
       },
       light: function(){
           $('.thumbPhoto a').colorbox({rel:'group1'});
       }
   }
});