define([
    'jquery', 
    'i18n!nls/logo.lang',
    'helpers/photos',
    'jqueryui', 
    'bootstrap', 
    'canTip', 
    'canToast'
], function($, lang, photos) {
   return {
       init: function(){
           var _this = this;
           this.drag();
           //if(!$.browser.msie && $.browser.version!="7.0") 
               _this.resizableLogo($('#logoImg'));                        
           
           this.binder();
           this.logo_text_edit_binder();
           this.footer_text_edit_binder();     
           
       },
       
       photo_add_binder: function(){
           //diyalogdaki logo yükleme tuşu
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
       
       binder: function(){
           var _this = this;
           var $loading = $('#loading');
           $('#logoTextBut').canTip({html: lang.but_logo_text});
           $('#logoPhotoBut').canTip({html: lang.but_logo_upload});
                      
           //diyalog açılışı
           $('body').on('click', '#logoPhotoBut', function(){
               _this.photo_add_binder();//multi select false
           });
           
           //yazı moduna geçirme
           $('body').on('click', '#logoTextBut', function(){
                $loading.show();
                $.post(base_url+"manage/logo/mode_text", {site_id: site_id, prefix: prefix}, function(data){
                    $loading.hide();
                    var json = $.parseJSON(data);
                    $.canToast(json.info);
                    $('#logo').html(json.html);
        
                $('#logoText').attr('contenteditable', 'true');
                });                
           });
           
       },
       
       logo_text_edit_binder: function(){
           var $loading = $('#loading');
           $('#logoText').canTip({html: lang.str_logo_edit});          
           $('#logoText').attr('contenteditable', 'true');
           
           $('body').on('focus', '#logoText', function(){//ie7 outline bug fix
               $(this).addClass('logoEditing');
           });
                      
           //deaktif olunca kaydet
           $('body').on('blur', '#logoText', function(e){             
               $(this).removeClass('logoEditing');//ie7 bug outline fix
               
               var logo = $(this).html();
               var len = logo.length;
               
               if(len < 3 || len > 250){
                   $.canToast('<div class="error">'+lang.err_logo_len+'</div>')
                   return false;
               }
               $loading.show();
                $.post(base_url+"manage/logo/update_logo", {site_id: site_id, logo: logo, prefix: prefix}, function(data){
                    $loading.hide();
                    $.canToast(data);
                });  
           });           
           //enter ile kayıt etme
           $('body').on('keypress', '#logoText', function(e){
                var code = (e.keyCode ? e.keyCode : e.which);
                if(code == 13) { 
                    $(this).blur();
                    return false;
                } 
           });           
       },
       
       footer_text_edit_binder: function(){   
            $('#footerText').canTip({html: lang.str_logo_edit});
            $('#footerText').attr('contenteditable', 'true');
            
           $('body').on('focus', '#footerText', function(){
               $(this).addClass('logoEditing');
           });
           
           $('body').on('blur', '#footerText', function(){
               $(this).removeClass('logoEditing');

               var text = $(this).html();
               var len = text.length;
               if(len < 3){
                   $.canToast('<div class="error">'+lang.err_footer_len+'</div>')
                   return false;
               }
                var $loading = $('loading');
                $loading.show();
                $.post(base_url+"manage/logo/update_footer", {site_id: site_id, text: text, prefix: prefix}, function(data){
                    $.canToast(data);
                    $loading.hide();
                });  

           });
                 
       },
       
       resizableLogo: function($elm){                    
         var ratio = $elm.attr('ratio');
         var src = $elm.attr('src');    
         if($elm.width() == 0){//hazir degilse iptal et
             return false;
         }
         
         $elm.resizable({
            containment: "#header",
            stop: function(e, ui){
                var width = $(this).width();
                var height = $(this).height();
                var $loading = $('#loading');
                $loading.show();
                    $.post(base_url+"manage/logo/resize", {site_id: site_id, width: width, height: height, prefix: prefix}, function(data){

                       $.canToast(data);
                       $loading.hide();
                       //yeniden boyutlandirilmis halini al
                       var stamp = new Date().getTime();
                       var newSrc = src+'?'+stamp;
                       $('#logoImg').attr('src', newSrc);
                    });  
            }
	 });             
       },
       
       send_to_backend: function(pic_id){
           var _this = this;
                        $.ajax({
                            type: 'post',
                            data: 'site_id='+site_id+'&pic_id='+pic_id + '&prefix=' + prefix,
                            url: base_url + 'manage/logo/update_image',
                            success: function(data){  
                                $('#photoForm').modal('hide');
                                //alanlari güncelleme
                                var json = $.parseJSON(data);
                                $.canToast(json.info);
                                $('#logo').html(json.html);
                                $('#logoImg').load(function(){
                                     _this.resizableLogo($(this));                                                                        
                                })
                            }
                        });             
       },
       
       drag: function(){     
           $( "#logo" ).draggable({
               containment: "#header", 
               scroll: false,
               handle: '#logoMoveBut',

               stop: function(e, ui){
                   var left = ui.position.left;
                   var top = ui.position.top;
                   var $loading = $('#loading');
                   $loading.show();
                    $.post(base_url+"manage/logo/position", {site_id: site_id, left: left, top: top, prefix: prefix}, function(data){
                       $loading.hide();
                       $.canToast(data);

                    } );                     
               }
           });           
       }
   }   
});