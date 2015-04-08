define(['jquery', 'bootstrap', 'colorbox'], function(){
    return {
        init: function(){
            this.settings_binder();
            this.setup_binder();
            this.feedback_binder();
            this.add_site();
            this.delete_site();
            this.unread_binder();
        },

        unread_binder: function() {
          $('#orders_but').click(function() {
              $('#unread_orders').fadeOut();
          });
        },
        add_site: function(){
            $('#add_site_but').click(function(){
                var $but = $(this);
                if($but.hasClass('active')){
                    $but.removeClass('active');
                    $('#addSiteForm').slideUp();
                }else{
                    $but.addClass('active');
                    $('#addSiteForm').slideDown();
                }
                return false;
            });

            $('#addSiteForm').submit(function(){
               var $elm = $(this);
               var data = $elm.serialize();
               var url = $elm.attr('data-action');
               var $but = $('input[type=submit]', $elm);

               $but.button('loading');
               $.post(url, data, function(data){
                    var json = $.parseJSON(data);
                    $but.button('complete');
                    $('#addSiteAlert').hide();
                    if(json.statu=="error"){//hata varsa goster
                        $('#addSiteAlert').html(json.message).fadeIn();
                    }else{//basarili
                        $('#add_site_but').removeClass('active');
                        $elm.slideUp();
                        $elm.find('[name="sitename"]').val('').next().show();
                        $('#sites_area').html(json.html);

                    }               
               });
            return false;
            });
        },

        delete_site: function(){
            var _this = this;
            $('body').on('click', '.delete-but', function(){
               var $but = $(this);
               var url = $but.attr('data-action');
               $but.button('loading');

               $.get(url, function(data){
                   $('#modalArea').html(data).children(":first-child").modal();
                   $but.button('complete');
                   //formu bind edelim
                   _this.delete_confirm();
               });

               return false;
            });
        },

        delete_confirm: function(){
            $('#delete-site-form').submit(function(){
               var $elm = $(this);
               var $but = $('input[type=submit]', $elm);
               var url = $elm.attr('data-action');
               var data = $elm.serialize();

               $('#form-alert').hide();
               $but.button('loading');
               $.post(url, data, function(response){
                   $but.button('complete');
                   var json = $.parseJSON(response);
                   if(json.statu == 'success'){
                       $elm.modal('hide');
                       $('#sites_area').html(json.sites);
                   }

                   if(json.statu=="error"){
                       $('#form-alert').html(json.message).fadeIn();
                   }
               });
               return false;
            });
        },

        setup_binder: function(){
            $('body').on('click', '.setup-but', function(){
                var $but = $(this);
                var url = $but.attr('data-action');
                $but.button('loading');

                $.get(url, function(data) {
                      $but.button('complete');
                      $('#modalArea').html(data).children(":first-child").modal();
                      $('.themeGlassBut').colorbox();
                });    

               return false;
            }); 

           //tema secme tusu
           $('body').on('click', '.themeSelectBut', function(){
              var $elm = $(this);
              var theme_id = $elm.attr('data-themeid');

              $('#themeForm').find('[name="theme_id"]').val(theme_id);
              $('#themes .btn-success').removeClass('btn-success');
              $elm.addClass('btn-success');
              return false;
           });

           //kaydetmece son islemler

           $('body').on('submit', '#themeForm', function(){
              var $elm = $(this);
              var url = $elm.attr('data-action');
              var data = $elm.serialize();
              var $but = $('input[type=submit]', $elm);

              $but.button('loading');

              $.post(url, data, function(data) {               
                   var json = $.parseJSON(data);
                   if(json.statu == "error"){
                       $but.button('complete');
                       $('#setupAlert').html(json.message);
                   }else{
                       window.location = json.url;
                   }
            });

            return false;
           });
        },

        feedback_binder: function(){
            $('#feedbackForm').submit(function(){
                var $elm = $(this);
                var url = $elm.attr('data-action');
                var data = $elm.serialize();
                $('#feedbackError').remove();

                $('#feedbackSendBut').button('loading');
                $('#feedAlert').hide();
                $.post(url, data, function(data) {
                    $('#feedAlert').html(data).fadeIn();
                    $('#feedbackSendBut').button('complete');
                    $('#feedbackTextarea').val('');

                });

                return false;
            });
            //feedleri getir
            $('body').on('click', '.feed', function(){
                var url = $(this).attr('data-feed-url');
                var loading = $('#loading');
                loading.show();
                $.get(url, function(data){
                    loading.hide();
                    $('#modalArea').html(data).children(":first-child").modal();
                });
            });
            //feed ccevapla
            $('body').on('submit', '#reply', function(){
                var $elm = $(this);
                var $but = $elm.find('[type=submit]');
                var $input = $elm.find('textarea');
                if($input.val() ==  ""){
                    alert('Lütfen mesaj girin.');
                    return false;
                }
                var url = $elm.attr('data-action');
                var data = $elm.serialize();

                $input.val('');
                $but.attr('disabled', 'disabled');
                $.post(url, data, function(data){
                    $but.removeAttr('disabled');
                    $elm.before(data);
                });

                return false;
            })
            //
            $('#messages_but').click(function(){
               var $but = $(this);
               var url = $but.attr('data-action');
               var $hover = $('#hover');
               var $butpar = $but.parent();
               //eger aciksa kapat
               if($butpar.hasClass('active')){
                   $butpar.removeClass('active');
                   $hover.hide();
                   return false;
               }

               $('#unread').remove();
               var height = $but.innerHeight();
               var width = Math.round($but.innerWidth() / 2);

               var top = $but.offset().top + height;
               var left = $but.offset().left - (Math.round($hover.innerWidth()/2)) + width;
               $butpar.addClass('active');
               $hover.css({'top': top, 'left': left}).show();

               $.get(url, function(data){
                   $('#hoverContent').html(data);
               });
               //baska yere tikanirsa kapat
               $(document).one('click', function(){
                  $but.parent().removeClass('active');
                  $hover.hide();
               });

               return false;
            });        
        },

        settings_binder: function(){
            var _this = this;
            $('body').on('submit', '#email_change', function(){
                    _this.settings_submit($(this));
               return false;
            });

            $('body').on('submit', '#pass_change', function(){
                    _this.settings_submit($(this));           
               return false;
            });        
        },

        settings_submit: function($elm){
               var url = $elm.attr('data-action');
               var data = $elm.serialize();
               var $but = $('input[type=submit]', $elm);

               $but.button('loading');
                   $.post(url, data, function(data){
                       $but.button('complete');
                       $('#dialog_alert').hide().html(data).fadeIn();
                   });        
        }
    };
});