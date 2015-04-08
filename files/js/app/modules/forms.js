define([
    'jquery', 
    'i18n!nls/forms.lang', 
    'common/forms', 
    'jqueryui', 
    'bootstrap', 
    'canTip', 
    'canToast'
], function($, lang, common) {
    
   return {      
       init: function(){
           $('.formsEditBut').canTip({html: lang.but_form_edit});
           this.binder();   
           common.init();
       },
       do_sortable: function(){
               var _this = this;
               $('#formEditDropList').sortable({
                   placeholder: 'formEditHolder',
                   start: function(){
                        $(document).disableSelection();//amk senin ie                       
                   },
                   stop: function(e, ui){
                       var $item = ui.item;
                     //üst toolbardan yeni eleman yaratmaca
                     if($item.hasClass('dragForm') == true){
                         var itemType = $item.attr('data-item-type');
                         var newItem = _this.do_list_item(itemType);
                         $item.after(newItem);
                         $item.remove();
                     }
                       $(document).enableSelection();//amk senin ie
                     
                   }
           });
               
               $( "#formEditDragList li" ).draggable({
			connectToSortable: "#formEditDropList",
			helper: "clone",
			revert: "invalid",
                        start: function(){
                            $(document).disableSelection();//amk senin ie
                            
                        },
                        stop: function(){
                           $(document).enableSelection();//amk senin ie
                            
                        }
		});           
       },
       
       binder: function(){
           var _this = this;
           $('body').on('click', '.formsEditBut', function(){
              var $loading  = $('#loading');
              var formId = $(this).parent().next().attr('id');
              formId = formId.split('_');
              formId = formId[1];
              
              $loading.show();
            $.post(base_url+"manage/forms/edit", {site_id: site_id, form_id: formId}, function(data){
               $loading.hide();
               $('#modal').html(data).children(':first-child').modal();
               
               _this.do_sortable();
               _this.edit_binder();
            });
           });  

                
       },
       
       edit_binder: function(){
           //checkbox value degistirici
           $('#formEditDropList').on('change', '.name-checkbox', function(){
               var $elm = $(this);
               var value = 0;
               if($elm.is(':checked')) value = 1;
               $elm.parent().parent().find('.name-required').val(value);
           });
           
           //silme islemi
           $('#formEditDropList').on('click', '.delete-field', function(){
              var $par = $(this).parent();
              //eger yeni olusturulmusa direk sil
              if($par.hasClass('newItem')){
                  $par.fadeOut(function(){
                      $par.remove();
                  });
              }else{
                  $par.fadeOut();
                  $par.find('.name-statu').val('delete');
              }
              return false;
           });
           
           //kaydetme islemleri
           $('#fieldsForm').submit(function(){
               var $elm = $(this);
               var $but = $elm.find('[type=submit]');
               var data = $elm.serialize();
               var form_id = $elm.find('[name=form_id]').val();
               
               $but.button('loading');
               $.post(base_url +'manage/forms/edit_do', data, function(data){
                        var json = $.parseJSON(data);  
                       $.canToast(json.info);
                       $('#form_'+form_id).html(json.html);  
                       $elm.modal('hide');
               });
               return false;
           });
       },

       do_list_item: function(itemType){
           var data = '<li class="newItem">\n';
               data += '<input type="text" name="label[]" class="formEditLabel" value="'+lang.label_new_field+'" />';
            
            if(itemType=='input'){
               data += ' <input type="text" name="type[]" class="span2" disabled="disabled" />';
            }
            
            if(itemType=='textarea'){
               data += ' <textarea class="span2" name="type[]" rows="2" disabled="disabled"></textarea>';
            }               
               data += ' <label class="form-label label label-important"><input name="checkbox[]" class="name-checkbox" type="checkbox" value="1" /> '+lang.label_required+'</label>'
               data += ' <a href="#" class="btn btn-danger btn-mini delete-field"><i class="icon-trash"></i></a>';
               data += '<input type="hidden" name="field_id[]" value="0" />';               
               data += '<input type="hidden" class="name-statu" name="statu[]" value="'+itemType+'" />';
               data += '<input type="hidden" class="name-required" name="required[]" value="0" />';
               data +='</li>';
           return data;
   }
   }
});
