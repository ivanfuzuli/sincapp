define(['jquery', 'bootstrap', 'plugins/jquery.maskedinput.min'], function($){
   return{
       init: function(){
       	  $('body').prepend('<div id="statsModal"></div>');
          this.binder();
       },
       binder: function() {
            var _this = this;
            $('body').on('click', '.stats-but', function(){
               var $but = $(this);
               var url = $but.attr('data-action');
               $but.button('loading');
               $.get(url, function(data){
                   $('#statsModal').html(data).children(":first-child").modal();
                   $but.button('complete');
               });
               return false;
            }); 
       }
    }
});