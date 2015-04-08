define(['jquery', 'bootstrap', 'datatables', 'tinymce', 'jquery_tinymce'], function($){
return{
    init: function(){

    $('.send-mail').click(function() {
      var $btn = $(this);
      var url = $btn.data('url');
      $btn.attr('disabled', 'disabled');
      $btn.html('Yükleniyor...');
      $.get(url, function(response) {
        console.log(response);
        $btn.html('Mail Atıldı');
      });
    });

    $('.connect-mail').click(function() {
      var $btn = $(this);
      var url = $btn.data('url');
      $btn.attr('disabled', 'disabled');
      $btn.html('Yükleniyor...');
      $.get(url, function(response) {
        console.log(response);
        $btn.html('Bağlandı.');
      });
    });

$('textarea').not('.add_mail').tinymce({
      entity_encoding : "raw"
   });
      if(typeof tableSource!= "undefined") {
        $('#myTable').dataTable( {
        "bProcessing": true,
        "sAjaxSource": tableSource,
        "bServerSide": true,
        "aaSorting" : [[0, 'desc']],
        "fnServerData": function (sSource, aoData, fnCallback) {
          $.ajax({
            'dataType': 'json',
            'type': 'POST',
            'url': sSource,
            'data': aoData,
            'success': fnCallback
          });
        },
        });        
      };

      if(typeof userTableSource != "undefined") {
        $('#myTable').dataTable( {
        "bProcessing": true,
        "sAjaxSource": userTableSource,
        "bServerSide": true,
        "aaSorting" : [[0, 'desc']],
        "fnCreatedRow": function( nRow, aData, iDataIndex ) {
      // Bold the grade for all 'A' grade browsers
        if ( aData[3] == "1" )
          {
            $('td:eq(4)', nRow).html( '<button class="btn btn-danger passiveUser" data-user-id="' + aData[0] + '">Aktifleştir</button> ' );
          } else {
            $('td:eq(4)', nRow).html( '<button class="btn btn-primary passiveUser" data-user-id="' + aData[0] + '">Pasifleştir</button> ' );
          }
        },
        "fnServerData": function (sSource, aoData, fnCallback) {
          $.ajax({
            'dataType': 'json',
            'type': 'POST',
            'url': sSource,
            'data': aoData,
            'success': fnCallback
          });
        },
        });        
      };

      if(typeof siteTableSource != "undefined") {
        $('#myTable').dataTable( {
        "bProcessing": true,
        "sAjaxSource": siteTableSource,
        "bServerSide": true,
        "aaSorting" : [[0, 'desc']],
        "fnCreatedRow": function( nRow, aData, iDataIndex ) {
      // Bold the grade for all 'A' grade browsers
        if ( aData[3] == "1" )
          {
            $('td:eq(4)', nRow).html( '<button class="btn btn-danger passiveSite" data-site-id="' + aData[0] + '">Aktifleştir</button> ' );
          } else {
            $('td:eq(4)', nRow).html( '<button class="btn btn-primary passiveSite" data-site-id="' + aData[0] + '">Pasifleştir</button> ' );
          }
        },
        "fnServerData": function (sSource, aoData, fnCallback) {
          $.ajax({
            'dataType': 'json',
            'type': 'POST',
            'url': sSource,
            'data': aoData,
            'success': fnCallback
          });
        },
        });        
      };      
        // buy domain 
        $('.buy-domain').click(function() {
          var $btn = $(this);
          var url = $btn.data('url');
          $btn.button('loading');
          $.get(url, function(data) {
              console.log(data);
              $btn.button('complete');
              $btn.removeClass('btn-success');
              $btn.addClass('btn-primary');
              $btn.attr('disabled', 'disabled');
          });

          return false;
        });

        $('.set-domain').click(function() {
          var $btn = $(this);
          var url = $btn.data('url');
          $btn.button('loading');
          $.get(url, function(data) {
              console.log(data);
              $btn.button('complete');
              $btn.removeClass('btn-success');
              $btn.addClass('btn-primary');
              $btn.attr('disabled', 'disabled');
          });

          return false;
        });

        $('.close-order').click(function() {
          var $btn = $(this);
          var url = $btn.data('url');
          $btn.button('loading');
          $.get(url, function(data) {
              $btn.parent().parent().remove();
          });

          return false;
        });
        //siteleri aktif/pasif yapma
        $('body').on('click', '.passiveSite', function(){
           var $but = $(this); 
           var site_id = $but.attr('data-site-id');
           var action = 0;
           $but.attr('disabled', 'disabled');
           //pasiflestir
           if($but.hasClass('btn-primary')){
               action = 1;
           }
           $.post(base_url+'kokpit/sites/passive', 'site_id='+site_id+'&statu='+action, function(statu){
               //pasiflestirildi
               if(statu==1){
                $but.removeClass('btn-primary').addClass('btn-danger').removeAttr('disabled').html('Aktifleştir');
               }
               //aktiflestirildi
               if(statu==0){
                $but.removeClass('btn-danger').addClass('btn-primary').removeAttr('disabled').html('Pasifleştir');           
               }
           })
        });

        // site silme
        $('.deleteSite').click(function(){
           var $but = $(this); 
           var site_id = $but.attr('data-site-id');
           $but.attr('disabled', 'disabled');

           $.post(base_url+'kokpit/delete_sites/confirm', 'site_id='+site_id, function(statu){
               //pasiflestirildi
               if(statu=="success"){
                $but.parent().parent().remove();
               }else{
                   alert('Oppsssss');
                   $but.removeAttr('disabled');
               }
           });

           return false;
        });

        //site silmeyi iptal etme
        $('.cancelSite').click(function(){
           var $but = $(this); 
           var site_id = $but.attr('data-site-id');
           $but.attr('disabled', 'disabled');

           $.post(base_url+'kokpit/delete_sites/cancel', 'site_id='+site_id, function(statu){
               //pasiflestirildi
               if(statu=="success"){
                $but.parent().parent().remove();
               }else{
                   alert('Oppsssss');
                   $but.removeAttr('disabled');
               }
           });

           return false;
        });

        //kullanıcıları aktif/pasif yapma
        $('body').on('click', '.passiveUser', function(){
           var $but = $(this); 
           var user_id = $but.attr('data-user-id');
           var action = 0;
           $but.attr('disabled', 'disabled');
           //pasiflestir
           if($but.hasClass('btn-primary')){
               action = 1;
           }
           $.post(base_url+'kokpit/users/passive', 'user_id='+user_id+'&statu='+action, function(statu){
               //pasiflestirildi
               if(statu==1){
                $but.removeClass('btn-primary').addClass('btn-danger').removeAttr('disabled').html('Aktifleştir');
               }
               //aktiflestirildi
               if(statu==0){
                $but.removeClass('btn-danger').addClass('btn-primary').removeAttr('disabled').html('Pasifleştir');           
               }
           })
        });

        //iletisim okunmadı isaretle

        $('.unreadContact').click(function(){
           var $but = $(this);
           var cid = $but.parent().attr('data-contact-id');

           $but.attr('disabled', 'disabled');
           $.post(base_url+'kokpit/contacts/unread', 'contact_id='+cid, function(data){
               if(data == 1){
               $but.removeAttr('disabled').html('Tamamdır');
               }else{
                   alert('bir hata olustu');
               }
           });
        });

        $('.deleteContact').click(function(){
           var $but = $(this);
           var cid = $but.parent().attr('data-contact-id');

           $but.attr('disabled', 'disabled');
           $.post(base_url+'kokpit/contacts/delete', 'contact_id='+cid, function(data){
               if(data == 1){
                   $but.parent().parent().slideUp();
               }else{
                   alert('bir hata olustu');
               }
           });   
        });

        //geribildirim

        $('.feed').click(function(){
           var url = $(this).attr('data-url');
           window.location = url;
        });

        $('#reply').submit(function(){
           var $elm = $(this);
           var data = $elm.serialize();

           $.post(base_url+'kokpit/feedbacks/reply', data, function(response){
               $elm.before(response);
           });

           return false;
        });

        //pinger

        //tumunu sec

        $('[name=checkall]').change(function(){
           if($(this).is(':checked')){
               $('input[name=ping\\[\\]]').attr('checked', true);
           }else{
               $('input[name=ping\\[\\]]').removeAttr('checked');
           }
        });        
    }
    
}    
});