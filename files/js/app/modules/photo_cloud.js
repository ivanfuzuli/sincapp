define(['jquery', 
    'i18n!nls/photo_cloud.lang', 
    'helpers/photos', 
    'jqueryui',
    'bootstrap', 
    'canTip', 
    'canToast'], function($, lang, photos) {
   return {
       firstRun: function(extId){
           var cloud_id = $('#ext_'+extId).find('.photo_cloud').attr('id');
           cloud_id = photos.id_splitter(cloud_id);
               
           this.photo_add_binder(cloud_id);         
       },
       init: function(){
           var _this = this;
           this.binder();
           this.sortable_do();
           photos.init();
           $('.photoEditBut').canTip({html: 'Düzenlemek için tıklayın.'});

           //ayarlar bölmünü açmaca
           $('body').on('click', '.photoEditBut', function(){
              var cloud_id = $(this).parent().next().attr('id');
              cloud_id = photos.id_splitter(cloud_id);
              $.post(base_url+"manage/photo_cloud/get_modal", {site_id: site_id, cloud_id: cloud_id},function(response) {
                $('#modal').html(response).children(':first-child').modal();
                $("#sort-slider tbody").sortable().disableSelection();
                _this.bind_form(cloud_id);
              });
           });
       },

       bind_form: function(cloud_id) {
            $('#photoSetForm').submit(function() {
                var data = $(this).serialize();
                var url = $(this).data('action');
                $('#photoSetSubmit').button('loading');
                var $cloud = $('#photoCloud_' + cloud_id);
                $.post(url, data, function(response){
                    $cloud.html(response);
                    $('#photoSetSubmit').button('complete');
                    $('#modal').children(':first-child').modal('hide');
                    $.canToast('<div class="success">Fotoğraf Albümü başarıyla güncellendi.</div>');
                });

                return false;
            });        
       }, 
       //fotograf eklerken photo modulune gonderilecek
       photo_add_binder: function(cloud_id){
           var _this = this;
           photos.add();//fotograflar diyalog kutusu

           $('#photoForm').submit(function(){
               var $elm = $(this);
               var seri = photos.serialize(); //secili photo idleri seriye döker               
               if(seri == false){
                   $.canToast('<div class="error">'+lang.err_select_photo+'</div> ');
                   return;                   
               }
               $elm.find('input[type=submit]').button('loading');               
               _this.send_to_backend(cloud_id, seri);
               return false;
           });   

       },
       
       binder: function(){
           var _this = this;
           $('.photoSelectBut').canTip({html: lang.but_select_photo});

           //dialogu acmaca           
           $('body').on('click', '.photoSelectBut',  function(){
               var cloud_id = $(this).parent().next().attr('id');
               cloud_id = photos.id_splitter(cloud_id);
               _this.photo_add_binder(cloud_id);
           });
                      
           //silme tusu
          $('body').on('mouseenter', '.thumbPhoto', function(){
              $(this).find('.remove_photo').show();
          });
          $('body').on('mouseleave', '.thumbPhoto', function(){
              $(this).find('.remove_photo').hide();
          });
          
          $('body').on('click', '.remove_photo', function(){
              var elem = $(this).parent();
              var photo_id = elem.attr('id');
              photo_id = photos.id_splitter(photo_id);
                $.ajax({
                    type: 'post',
                    data: 'site_id='+site_id+'&photo_id='+photo_id,
                    url: base_url + 'manage/photo_cloud/delete',
                    success: function(data){
                        
                        $.canToast(data);
                        
                        elem.fadeOut(function(){
                            //eger kardes yoksa fotograf yok diye yaz                       
                            if(elem.siblings().size() < 1){
                                elem.after(lang.str_no_photo);
                            }
                            $(this).remove();
                        
                        });   
                    }});              
          });
       },
       
       sortable_do: function(){
        $('.photo_cloud').sortable({

            update: function(){
                var serialized =  $(this).sortable('serialize');
                $.ajax({
                    type: 'post',
                    data: serialized+'&site_id='+site_id,
                    url: base_url + 'manage/photo_cloud/sort',
                    success: function(data){  
                        $.canToast(data);
                    }});
            }
        });           
       },
       send_to_backend: function(cloud_id, photos){
                        var _this = this;
                        $.ajax({
                            type: 'post',
                            data: photos+'&site_id='+site_id+'&cloud_id='+cloud_id,
                            url: base_url + 'manage/photo_cloud/add',
                            success: function(data){  
                                $('#photoForm').modal('hide');
                                $('#photoCloud_'+cloud_id).html(data);
                                _this.sortable_do();
                                $('.photo_cloud').sortable( "refreshPositions" );
                            }
                        });           
       }
   }     
});
