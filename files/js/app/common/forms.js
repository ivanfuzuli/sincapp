define(['jquery'], function($) {
   return {
       init: function(){
           this.binder();
       },
       refresh_captcha: function(src){
           var stamp = new Date().getTime();
           src = src+'?'+stamp;
                 
           $('.captcha').attr('src', src);
       },      
       binder: function(){
          var _this = this;

           $('body').on('click', '.refresh_captcha', function() {
                var src = $(this).data('captcha');
                _this.refresh_captcha(src);
                return false;
           });
           $('body').on('submit', '.formSend', function(){
               var $elm = $(this);
               var stop = false;
               $elm.find('.formError, .phraseError').hide();
               
               //Gerekli checker
               $(this).find('.required').each(function(){
                   if($(this).val() == ""){
                       $elm.find('.formError').fadeIn();
                       stop = true;
                   };
               })
               if(stop == true){
                   return false;
               }
               
               var data = $elm.serialize();
               var url = $elm.attr('data-action');
               var $but = $elm.find(':submit');
               $but.attr('disabled', 'disabled');
               $('body').css('cursor', 'wait');
               $.post(url, data, function(response){
                  $but.removeAttr('disabled');
                  $('body').css('cursor', 'auto');
                    if(response == 'phrase_error') {
                        $elm.find('.phraseError').fadeIn();
                        return false;
                    }
                    alert(response);
                    var src = $elm.data('captcha');
                    _this.refresh_captcha(src);
                    //alanlari temizlemece
                    $elm.find(':input').not(':button, :submit, :reset, :hidden').each(function() {
                            $(this).val('');
                            $but.removeAttr('disabled');
                    });
                    
                });
               
               return false;
           })
       }
   }
});