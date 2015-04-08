define([
    'jquery', 
    'i18n!nls/extension.lang', 
    'modules/grids', 
    'bootstrap', 
    'canTip', 
    'canToast'
], function($, lang, grids){    

    return{
        init: function(){
            grids.init();
            
            this.tooltip();
            this.ext_delete_binder();
        },

        tooltip: function(){    
            $('.mergeMe').canTip({html: lang.str_merge});
            $('.ext_delete').canTip({html: lang.str_ext_delete});            
        },
        
        ext_delete_binder: function(){
        //eklenti silme

        $('body').on('click', '.ext_delete', function(){
            var item = $(this).parent().parent();

            var ext_id = item.attr('id');
            ext_id = ext_id.split('_');
            ext_id = ext_id[1];

            var answer = confirm(lang.confirm_ext_delete);
            if (!answer){
                return false;
            }
            
            var $loading = $('#loading');
            $loading.show();
            $.post(base_url+"manage/extensions/delete", {site_id: site_id, ext_id: ext_id}, function(data){

                var json = $.parseJSON(data);
               //bilgilendirme mesaji
                $.canToast(json.html);
                if(json.error == false){ //eger hata mesajı yoksa bu eklentiyi sil bebek
                    item.fadeOut(function(){$(this).remove()});
                }
                
                $loading.hide();
            });        
        });            
        }
    } 
});