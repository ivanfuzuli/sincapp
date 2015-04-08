define(['jquery', 'bootstrap'], function($) {
   return {
       init: function(){  
           this.binder();
       },
       
       binder: function(){
           var _this = this;
           $('#socialBut').click(function(){
               var $loading = $('#loading');
               var url = base_url + 'manage/social/index';
               $loading.show();
               $.post(url, {site_id: site_id, prefix: prefix}, function(data){
                   $loading.hide();
                  $('#modal').html(data).children(':first-child').modal().on('hidden', function () {
                      $('#social').effect('bounce');
                  }); 
                  _this.do_binder();
               });
               
               return false;
           });
       },
       
       do_binder: function(){

           $('.switch-social').click(function(){
               var $elm = $(this);
               var $next = $elm.next();
               var input_name = $elm.data('input');
               var $input = $('[name="'+ input_name +'"]');
               if($next.val()=="1"){
                   $next.val('0');
                   $elm.animate({left: "-56px"}, 200);
                   $input.hide().val('');
               }else{
                   $next.val('1');
                   $elm.animate({left: "0px"}, 200);
                   $input.show();
               }
           });

           $('#socialEditForm').submit(function(){
              var $elm = $(this);
              var $but = $elm.find('[type=submit]');
              var data = $elm.serialize();
              data = data + '&prefix=' + prefix;
              var url = base_url + 'manage/social/post';
              
              $but.button('loading');
              
              $.post(url, data, function(data){
                 $but.button('complete'); 
                $.canToast('<div class="success">Sosyal medya simgeleriniz başarıyla güncellendi.</div>');
                $('#social').html(data);

              });
              return false;
           });
       }
   }
});