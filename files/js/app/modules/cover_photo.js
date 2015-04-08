define(['jquery', 'i18n!nls/cover_photo.lang', 'helpers/photos', 'bootstrap', 'canTip', 'canToast'], function($, lang, photos) {
   return {
       init: function(){
           this.binder();
       },
       
       binder: function(){
           var _this = this;
           this.add_elements();

           $('#no_cover').click('click', function() {
              _this.no_cover();
              $("#cover_drop_down").dropdown("toggle");              
              return false;
           })
           $('#add_cover_photo').click(function() {
              _this.cover_add_binder();
              $("#cover_drop_down").dropdown("toggle");
              return false;
           });
       },
       add_elements: function () {
           var str = '<div class="btn-group btn-absolute">';
               str += '<button class="btn dropdown-toggle" data-toggle="dropdown" title="Kapak Fotoğrafı"><i class="icon-picture"></i>Kapak<span class="caret"></span></button>';
               str +='<ul class="dropdown-menu" id="cover_drop_down">';
               str += '<li><a id="no_cover" href="#">Kapak Yok</a></li>';
               str += '<li><a id="add_cover_photo" href="#">Fotoğraf Seç</a></li>';
               str += '</ul>';
               str += '</div>';
           $('#cover-photo').prepend(str);        
       },

       edit_cover_binder: function (data) {
            var _this = this;
            $('#cover-photo').addClass('cover-max').addClass('cover-zindex');

            //alanlari güncelleme
            $('#black_area').fadeIn();
            var json = $.parseJSON(data);

            var str = '<div id="cover-save-container">';
                str += '<a href="#" class="btn" id="save_cover"><i class="icon-ok"></i>Kaydet</a>';
                str += '</div>';

            $cover_photo = $('#cover-photo');
            var img = '<img src="' + json.image + '" />';
            $cover_photo.html(  str + '<div id="cover-drag" class="move-cursor"> '+ img + '</div><div id="cover-info">Kapağı yeniden konumlandırmak için sürükle.</div>');

            $("#cover-drag").draggable({
                axis: "y"
            });

            $('#save_cover').click(function () {
                var y = $('#cover-drag').css('top');
                $.ajax({
                    type: 'post',
                    data: 'site_id=' + site_id + '&y=' + y,
                    url: base_url + 'manage/cover/crop_image',
                    success: function(data){ 
                    _this.binder();
                    $.canToast(data);
                    $('#black_area').fadeOut();
                    $('#cover-drag').draggable('destroy');
                    $('#cover-drag').removeClass('move-cursor');
                    $('#cover-info').remove();
                    $('#cover-save-container').remove();
                    $('#cover-photo').removeClass('cover-zindex');
                   }
               });
              return false;
            });
       },
       cover_add_binder: function() {
           var _this = this;
           photos.add(false);

           $('#photoForm').submit(function(){
               var pic_id = $('.active_pic').attr('id');
               pic_id = photos.id_splitter(pic_id);
               $(this).find('input[type=submit]').button('loading');   
               
               _this.send_to_backend(pic_id);
               
               return false;
           }); 
       },

       send_to_backend: function(pic_id) {
           var _this = this;
                        $.ajax({
                            type: 'post',
                            data: 'site_id='+site_id+'&pic_id='+pic_id,
                            url: base_url + 'manage/cover/update_image',
                            success: function(data){  
                                $('#photoForm').modal('hide');
                                //alanlari güncelleme
                                _this.edit_cover_binder(data);
                            }
                        });         
       },

       no_cover: function() {
                        $.ajax({
                            type: 'post',
                            data: 'site_id='+site_id,
                            url: base_url + 'manage/cover/no_cover',
                            success: function(data){  
                                //alanlari güncelleme
                                $.canToast(data);
                                $cover_photo = $('#cover-photo');
                                $cover_photo.removeClass('cover-max');
                                $cover_photo.find('img').remove();
                            }
                        });         
       }

   }
});
