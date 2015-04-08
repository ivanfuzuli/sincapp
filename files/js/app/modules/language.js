define(['jquery', 'canTip', 'canToast'], function($, lang) {
   var val;
   return {
       init: function(){
          var _this = this;
          _this.binder();

          if(language_setup == 1) {
              _this.open_dialog();
          }
       },
       binder: function() {
        var _this = this;
          $('#lang-select').canTip({html: 'Çoklu dil eklemek için tıklayın.'});
          $('#lang-select').click(function() {
              $.post(base_url+"manage/language/get_modal", {site_id: site_id, prefix: prefix},function(response) {
                  $('#modal').html(response).children(':first-child').modal();
                  _this.switch_binder();
              });
          });
       },

       open_dialog: function() {
            var _this = this;
            $.post(base_url+"manage/language/get_setup", {site_id: site_id, prefix: prefix},function(response) {
                $('#modal').html(response).children(':first-child')
                .modal({
                    backdrop: 'static',
                    keyboard: true
                  });
                _this.lang_setup_binder();
            });
       },

       lang_setup_binder: function() {
          $('#langSetupForm').submit(function() {
              var $but = $('#langSetupSubmit');
              var data = $(this).serialize();
              $but.button('loading');
              $.post(base_url+"manage/language/set_setup", data, function(response) {
                  $('#modal').children(':first-child').modal('hide');
              });              
              return false;
          });
       },
       switch_binder: function () {
          var value;
           $('.switch-language').click(function(){
               var $elm = $(this);
               value = $elm.data('value');
               if(value=="1"){
                   $elm.data('value', 0);
                   value = 0;
                   $elm.animate({left: "-56px"}, 200);
               }else{
                   $elm.data('value', 1);
                   value = 1;
                   $elm.animate({left: "0px"}, 200);
               }

               $('#languageLoading div').fadeIn();
               $.post(base_url+"manage/language/set_language", {site_id: site_id, statu: value},function(response) {
                    if (value == 1) {
                        $('#lang-changer').fadeIn();
                    } else {
                       $('#lang-changer').fadeOut();
                    }
                    $('#languageLoading div').fadeOut();
                    $('#language').html(response);
               });                   
           });

           $('.switch-change-site').click(function(){
               var $elm = $(this);
               var value = $elm.data('value');
               if(value=="1"){
                   $elm.data('value', 0);
                   value = 0;
                   $elm.animate({left: "-56px"}, 200, function() {
                          window.location = base_url + "manage/editor/wellcome/" + site_id + "/en";
                   });
               }else{
                   $elm.data('value', 1);
                   value = 1;
                   $elm.animate({left: "0px"}, 200, function() {
                        window.location = base_url + "manage/editor/wellcome/" + site_id;
                   });
               };
           });           
       }
    }
});
