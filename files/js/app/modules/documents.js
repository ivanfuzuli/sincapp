define(['jquery', 
    'helpers/files', 
    'bootstrap', 
    'canTip', 
    'canToast'], function($, files) {
   return {
       firstRun: function(extId){
           var document_id = $('#ext_'+extId).find('.documents').attr('id');
           document_id = files.id_splitter(document_id);
          
           files.add(0);
           this.bind_form(document_id);         
       },

       init: function() {
          var _this = this;
          files.init();
          $('.documentEditBut').canTip({html: 'Döküman eklemek için tıklayın.'});
          $('.rename-document').canTip({html: 'Dökümanın adını değiştirmek için tıklayın.'});
          $('body').on('click', '.documentEditBut', function() {
              files.add(0);
              var doc_id = $(this).parent().parent().find('.documents').attr('id');
              doc_id = files.id_splitter(doc_id);
              _this.bind_form(doc_id);
          });
       },

       bind_form: function(document_id) {
            $('#documentForm').submit(function() {
                var file_id = files.get_selected_id();
                var url = base_url + 'manage/documents/update';
                $.post(url, {site_id: site_id, document_id: document_id, file_id: file_id}, function(response) {
                      $('#documentForm').modal('hide');
                      $('#document_' + document_id).html(response);
                });
                return false;
            });        
       }
  }
});