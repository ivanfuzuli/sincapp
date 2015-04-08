define([
    'jquery', 
    'i18n!nls/slider_cloud.lang', 
    'helpers/photos', 
    'common/slider_cloud', 
    'jqueryui',
    'bootstrap', 
    'canTip', 
    'canToast'
], function($, lang, photos, cloud) {
   return {
       firstRun: function(extId){
           var cloud_id = $('#ext_'+extId).find('.flexslider').attr('id');
           cloud_id = photos.id_splitter(cloud_id);

           this.photo_add_binder(cloud_id);              
       },
       init: function(){
           $('.sliderUploadBut').canTip({html: lang.str_slider_add_but});
           $('.sliderRemoveBut').canTip({html: lang.str_slider_del_but});
           $('.sliderOpenBut').canTip({html: lang.str_slider_edit_but});
           this.binder();
           cloud.init();
           
       },
       //fotograf ekleme formunu bind et
       photo_add_binder: function(cloud_id){
           var _this = this;
                photos.add();
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
           $('body').on('click', '.sliderUploadBut', function(){
                var cloud_id = $(this).parent().next().attr('id');
                cloud_id = photos.id_splitter(cloud_id);
                _this.photo_add_binder(cloud_id);
           });
           
           
           //ayarlar bölmünü açmaca
           $('body').on('click', '.sliderOpenBut', function(){
              var cloud_id = $(this).parent().next().attr('id');
              cloud_id = photos.id_splitter(cloud_id);
              $.post(base_url+"manage/slider_cloud/get_modal", {site_id: site_id, cloud_id: cloud_id},function(response) {
                $('#modal').html(response).children(':first-child').modal();
                $("#sort-slider tbody").sortable().disableSelection();
                _this.bind_form(cloud_id);
              });
           });
           
           
           //silmece
           $('body').on('click', '.btn-remove-slide', function(){             
               var $elm = $(this);
               $elm.next().val(1);
               $elm.parent().parent().fadeOut();
               return false;
           });
       },

       bind_form: function(cloud_id) {
            $('#sliderSetForm').submit(function() {
                var data = $(this).serialize();
                var url = $(this).data('action');
                $('#sliderSetSubmit').button('loading');
                var $cloud = $('#sliderCloud_' + cloud_id);
                $.post(url, data, function(response){
                    $cloud.flexslider('destroy');
                    $cloud.html(response);
                    $cloud.flexslider();
                    $('#sliderSetSubmit').button('complete');
                    $('#modal').children(':first-child').modal('hide');
                    $.canToast('<div class="success">Slider başarıyla güncellendi.</div>');
                });

                return false;
            });        
       },
       send_to_backend: function(cloud_id, photos){
           var _this = this;
                        $.ajax({
                            type: 'post',
                            data: photos+'&site_id='+site_id+'&cloud_id='+cloud_id,
                            url: base_url + 'manage/slider_cloud/add',
                            success: function(data){  
                                var json = $.parseJSON(data); 
                                var $elm = $('#sliderCloud_'+cloud_id);   
                                $('#photoForm').modal('hide');
                                if($elm.hasClass('flex-active')) {
                                  $elm.flexslider('destroy');
                                }
                                $('#sliderCloud_'+cloud_id).html(json.main);
                                $('#sliderCloud_' + cloud_id).addClass('flex-active').flexslider();
                            }
                        });   
        }          
   }
});