define(['jquery', 'bootstrap'], function($) {
   return {
       init: function(){  
           this.binder();
       },
       
       binder: function(){
           var _this = this;
           $('#settingsBut').click(function(){
               var $loading = $('#loading');
               var url = base_url + 'manage/settings/index';
               $loading.show();
               $.post(url, {site_id: site_id, prefix: prefix}, function(data){
                   $loading.hide();
                  $('#modal').html(data).children(':first-child').modal(); 
                  _this.do_binder();
               });
               
               return false;
           });
       },
       
       do_binder: function(){
           $('#pageEditForm').submit(function(){
              var $elm = $(this);
              var $but = $elm.find('[type=submit]');
              var $log = $('#settingsLog');
              var data = $elm.serialize();
              data = data + '&prefix=' + prefix;
              var url = base_url + 'manage/settings/set_settings';
              
              $but.button('loading');
              $log.hide();
              
              $.post(url, data, function(data){
                 $log.html(data).fadeIn();
                 $but.button('complete'); 
              });
              return false;
           });
       }
   }
});