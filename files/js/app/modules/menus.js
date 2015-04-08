define(['jquery', 'i18n!nls/htmls.lang', 'modules/pages', 'bootstrap', 'canTip', 'canToast'], function($, lang, pages) {
   return {
       firstRun: function(extId){
           var menuID = $('#ext_'+extId).find('.menuArea').attr('id');
              menuID = menuID.split('_');
              menuID = menuID[1];
              
              this.menu_modal(site_id, menuID);
       },
       
       init: function(){
           this.binder();
           this.delete_binder();
           this.bind_sortable($( ".nav-stacked" ));
           $('.menuEditBut').canTip({html: 'Menüyü düzenlemek için tıklayın.'});
       },
       
       binder: function(){
           var _this = this;
           $('body').on('click', '.menuEditBut', function(){
              var menuID = $(this).parent().next().attr('id');
              menuID = menuID.split('_');
              menuID = menuID[1];
              _this.menu_modal(site_id, menuID);
           });

           $('body').on('mouseenter', '.nav-stacked > li', function() {
              $(this).find('span').fadeIn();
           });
           $('body').on('mouseleave', '.nav-stacked > li', function() {
              $(this).find('span').hide();
           });           
       },
       delete_binder: function() {
          $('body').on('click', '.delete-menu', function() {
              var $elm = $(this).parent();
              var id = $elm.attr('id');
              id = id.split('_');
              id = id[1];
             $elm.fadeOut();
             $.post(base_url + '/manage/menu/remove', {'site_id' : site_id, 'prefix': prefix, 'id': id}, function(response) {
                  $.canToast('<div class="success">Menü elemanı başarılı bir şekilde silinmiştir.</div>');
             }); 
          });
       },

       bind_sortable: function($elm) {
          $( ".nav-stacked" ).sortable({
            update: function( event, ui ) {
                var data = $(this).sortable('serialize');
                data += '&site_id=' + site_id;

                $.post(base_url + 'manage/menu/sort', data, function(response) {
                    $.canToast('<div class="success">Menü sıralaması başarılı bir şekilde güncellendi.</div>');
                });

            }
          });
       },
       menu_modal: function(site_id, menuID){
            var _this = this;
            $.post(base_url+"manage/menu/get_modal", {site_id: site_id, menu_id: menuID, prefix: prefix}, function(response){
                $('#modal').html(response).children(':first-child').modal();
                _this.bind_radio();
                _this.bind_form(menuID);
            });
       },

       bind_radio: function() {
            $('input[name="page_type"]').change(function() {
                var val = $(this).val();
                if(val == 'existing') {
                    $('#menu_page_id').show();
                    $('#menu_page_title').hide();
                } else {
                    $('#menu_page_id').hide();
                    $('#menu_page_title').show();                 
                }
            });
       },

       bind_form: function(menuID) {
            var _this = this;
            $('#menu_page_add').submit(function() {
                if ($('input[name="page_type"]:checked').val() == 'new') {
                   if($('#menu_page_title').val() == "") {
                      $.canToast('<div class="error">Lütfen sayfa başlığı giriniz.</div>');
                      return false;
                   }
                }
                var $but = $('#subPageAddBut');
                $but.button('loading');
                var data =  $(this).serialize();
                var url = $(this).data('action');
                console.log(data);
                $.post(url, data, function(json) {
                    $.canToast('<div class="success">Sayfa başarılı bir şekilde eklenmiştir.</div>');
                    json = $.parseJSON(json);
                    $but.button('complete');
                    var $elm = $('#menu_' + menuID).find('ul');
                    $elm.sortable('destroy');
                    $elm.html(json.main);
                    $elm.find('ul').sortable('refrestPosition');
                    _this.bind_sortable($elm);

                    pages.update_area(json.pages_content, json.pages_switcher);
                });
                return false;
            });
       }
   }
});
