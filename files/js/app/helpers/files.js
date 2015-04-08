define(['i18n!nls/photos.lang', 'plugins/jquery.swfupload'], function(lang) {
   return {
       multi: true, //coklu secim
       init: function(){
         var _this = this;
         $('.remove-document').canTip({html: 'Dökümanı silmek için tıklayın.'});
         $('body').on('click', '.remove-document', function(){
             var file_id = $(this).data('id');
             var file = $('#file_' + file_id);
             
             var answer = confirm('Bu dökümanı gerçekten silmek istiyor musunuz?');
             
             if(answer == true){
                _this.del(file);
             }
         }) ;
 
        // RENAME
        $('body').on('focus', '.rename-document', function() {
            var $elm = $(this);
            $('body').on('click.rename', function(e) {
                  var target = $(e.target);
                  if(target.is($elm)) {
                    return false;
                  }

                  _this.rename($elm);
            });
        });

        $('body').on('keydown', '.rename-document', function(ev) {
            var keycode = (ev.keyCode ? ev.keyCode : ev.which);
            if (keycode == '13') {
                _this.rename($(this));
                $(this).blur();
                ev.preventDefault();
                return false;
            }
        });

        // \ RENAME
        $('body').on('click', '.select-document', function(){
             var $elem = $(this);

             //seciliyse secimi kaldir yoksa sec
             if($elem.hasClass('btn-success')){
                 $elem.removeClass('btn-success');
                 $elem.parent().parent().removeClass('success');
             }else{
                _this.reset_active();
                $elem.addClass('btn-success');
                $elem.parent().parent().addClass('success');
             }
             
             _this.active_but();

             return false;
         });

       },

       rename: function($elm) {
            var file_id = $elm.data('id');
            var name = $elm.html();
            var url = base_url + 'manage/files/rename';
            $.post(url, {site_id: site_id, file_id: file_id, name: name}, function(response) {
                $.canToast('<div class="success">Döküman adı başarılı bir şekilde güncellendi.</div>');
            });

            $('body').off('click.rename');
       },
       active_but: function(){
         //ekleme tusunu aktif pasif yap  
         var $elm = $('#documentTable').find('.btn-success');
         if($elm.length < 1){
             $('#addDocumentBut').attr('disabled', 'disabled');
         }else{
             $('#addDocumentBut').removeAttr('disabled');            
         }
       },

       reset_active: function() {
          $('#documentTable').find('.success').removeClass('success');
          $('#documentTable').find('.btn-success').removeClass('btn-success');
       },

       del: function(file){
             var file_id = file.attr('id');
             var _this = this;
             file_id = file_id.split("_");
             file_id = file_id[1];
             
            $.post(base_url+"manage/files/remove", {site_id: site_id, file_id: file_id}, function(data){
                
                 $.canToast(data);
                 file.fadeOut('fast', function(){
                     $(this).remove();
                     _this.active_but();
                 })

            });            
       },
       add: function(multi_select){
           multi_select = typeof multi_select !== 'undefined' ? multi_select : 1;
           this.multi = multi_select; // coklu secim durumu
           var _this = this;
           var $loading = $('#loading');
           $loading.show();
            $.ajax({
                url: base_url+"manage/files/add",
                type: 'POST',
                async: false,//istegin tamamlanmasini bekle yoksa dom hazir olmaz diger fonksiyon bind edemez
                data: {site_id: site_id},
                success: function(data){
                   $('#modal').html(data).children(':first-child').modal();                 
                   _this.uploader();                    
                   $loading.hide();
                   
                }
            })

       },

       get_selected_id: function(){
          var _this = this;
          var $elm = $('#documentTable').find('.btn-success');
          if($elm.length < 1) {
              return false;
          } else {
             var id = $elm.data('id');
             return id;
          }
        },

       
       uploader: function(){
        var _this = this;
	$('#swfupload-control').swfupload({
		upload_url: base_url+"manage/upload/upload_document",
		file_size_limit : "20240",
		file_types : "*.txt; .pdf; *.doc; *.docx; *.xls; *.odt; *.odp; *.ods; *.ppt; *.TXT; *.PDF; *.DOC; *.DOCX, *.XLS, *.ODT; *.ODP; *.ODS; *.PPT",
		file_types_description : 'txt, pdf, doc, docx, xls, odt veya odp formatında dosyalar',
		file_upload_limit : "0",
		flash_url : base_url+"files/js/app/plugins/swfupload/swfupload.swf",
		button_image_url : base_url+'files/js/app/plugins/swfupload/upload-document.png',
                button_window_mode: 'transparent',                
		button_width : 180,
		button_height : 40,
		button_placeholder : $('#button')[0],
		debug: false,
		post_params: {"token":$('#token').val(), "_token": _token}
	})
		.bind('swfuploadLoaded', function(event){
		//	$('#log').append('<li>Loaded</li>');
        //Mac OS OBJECT bug fix
        $('#swfupload-control').animate({
          marginLeft: '+=1px'
        }, 500);
           
		})
		.bind('fileQueued', function(event, file){
		//	$('#log').append('<li>File queued - '+file.name+'</li>');
			// start the upload since it's queued
			$(this).swfupload('startUpload');
		})
		.bind('fileQueueError', function(event, file, errorCode, message){
		//	$('#log').append('<li>File queue error - '+message+'</li>');
		})
		.bind('fileDialogStart', function(event){
		//	$('#log').append('<li>File dialog start</li>');
		})
		.bind('fileDialogComplete', function(event, numFilesSelected, numFilesQueued){
		//	$('#log').append('<li>File dialog complete</li>');
		})
		.bind('uploadStart', function(event, file){
			$('#swfupload-control').after('<div class="progress-bar"><div></div></div>');
		})
		.bind('uploadProgress', function(event, file, bytes, total){
                    var percent = 100 * bytes / total;
                    percent = Math.round(percent); //yuvarlama
                    $(".progress-bar div").animate({width: percent + "%"}, {duration: 500, queue: false}).html(percent+'%');                    
		})
		.bind('uploadSuccess', function(event, file, serverData){
		//	$('#log').append('<li>Upload success - '+file.name+'</li>');
                    _this.reset_active();
                    $(".progress-bar").remove();

                    if(serverData == 'storage_limit_error') {
                        $.canToast('<div class="error">Dosya yükleme limiti aşıldı. Lütfen bazı dosyaları silip tekrar deneyiniz.</div>');
                        return false;
                    };

                    $.canToast('<div class="success">'+lang.info_success_upload+' {' +file.name+'}</div>' );
                    
                    var filesrc = $(serverData);
                    filesrc.hide();
                    $('.table-files').prepend(filesrc);
                    filesrc.fadeIn('slow');
                    _this.active_but();
		})
		.bind('uploadComplete', function(event, file){
		//	$('#log').append('<li>Upload complete - '+file.name+'</li>');
			// upload has completed, lets try the next one in the queue
			$(this).swfupload('startUpload');
		})
		.bind('uploadError', function(event, file, errorCode, message){
                  $(".progress-bar").remove();
		  $.canToast('<div class="error">'+lang.info_error_upload+'</div>' );
		}); 

       },
       id_splitter: function(str){
           str = str.split('_');
           str = str[1];
           return str;
       }       
       
   }

});
