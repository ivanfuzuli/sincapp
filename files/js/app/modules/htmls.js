define(['jquery', 'i18n!nls/htmls.lang', 'bootstrap', 'canTip', 'canToast'], function($, lang) {
   return {
       firstRun: function(extId){
           var htmlId = $('#ext_'+extId).find('.htmlArea').attr('id');
              htmlId = htmlId.split('_');
              htmlId = htmlId[1];
              
              this.html_dialog("", htmlId);
       },
       
       init: function(){
           this.binder();
           $('.htmlEditBut').canTip({html: lang.str_edit_html});
       },
       
       binder: function(){
           var _this = this;
           $('body').on('click', '.htmlEditBut', function(){
              var htmlId = $(this).parent().next().attr('id');
              htmlId = htmlId.split('_');
              htmlId = htmlId[1];

            $.post(base_url+"manage/htmls/get_html", {site_id: site_id, html_id: htmlId}, function(data){
               _this.html_dialog(data, htmlId);
               
            });
           });

       },
       edit_binder: function(){
           $('#htmlEditForm').submit(function(){
               var $elm = $(this);
               var $but = $elm.find('[type=submit]');
               var htmlId = $elm.attr('data-html-id');
               var content = $('#htmlEditContent').val();
               $but.button('loading');
                $.post(base_url+"manage/htmls/set_html", {site_id: site_id, html_id: htmlId, content: content}, function(response){
                     $('#html_'+htmlId).html(response);
                      $.canToast('<div class="info">'+lang.succ_edit_html+'</div>');  
                      $elm.modal('hide'); 
                });               
               return false;
           });
       },
       html_dialog: function(data, htmlId){
           var str = '<form class="modal fade" name="htmEditForm" id="htmlEditForm" data-html-id="'+htmlId+'" action="#" method="post">';
           str += '<div class="modal-header"><a class="close" data-dismiss="modal">×</a><h3>'+lang.str_html_title+'</h3></div>';
           str += '<div class="modal-body">';
           str += '<textarea id="htmlEditContent" class="htmleditor">'+data+'</textarea>';
           str += '</div>';
           str += '<div class="modal-footer"><a class="btn" data-dismiss="modal">'+lang.but_close+'</a>';
           str += '<input type="submit" class="btn btn-primary" data-loading-text="'+lang.str_please_wait+'" data-complete-text="'+lang.but_edit_html+'" value="'+lang.but_edit_html+'"/>';
           str += '</div></form>';
          
          $('#modal').html(str).children(':first-child').modal(); 
          this.edit_binder();
       }
   }
});
