define(['i18n!nls/photos.lang', 'jquery.fileupload', 'jquery.fileupload.validate'], function(lang) {
   return {
       multi: true, //coklu secim
       options: {
          acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
          maxFileSize: '10000000',
          swfupload: {
              file_types: "*.jpg; .jpeg; *.png; *.gif; *.JPG; *.JPEG; *.PNG; *.GIF",
              file_size_limit: "10240"
          }
       },
        is_ie: function() {
        var myNav = navigator.userAgent.toLowerCase();
          return (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
        },       
       init: function(){
         var _this = this;
         $('.pic_del').canTip({html: lang.str_delete_photo});
         $('body').on('click', '.pic_del', function(){
             var picture = $(this).parent();
             
             var answer = confirm(lang.confirm_delete_photo);
             
             if(answer == true){
                _this.del(picture);
             }
         }) ;
         
         $('body').on('click', '.pic_box', function(){
             var $elem = $(this);
             
             if(_this.multi == false){//birden fazla seceme sadece tek sec
                 $elem.parent().find('.active_pic').removeClass('active_pic');
             }
             
             //seciliyse secimi kaldir yoksa sec
             if($elem.hasClass('active_pic')){
                 $elem.removeClass('active_pic');
             }else{
                $elem.addClass('active_pic');
             }
             
             _this.active_but();
         });

       },
       active_but: function(){
         //ekleme tusunu aktif pasif yap  
         if($('.active_pic').length < 1){
             $('#addPhotoBut').attr('disabled', 'disabled');
         }else{
             $('#addPhotoBut').removeAttr('disabled');            
         }
       },
       del: function(picture){
             var pic_id = picture.attr('id');
             var _this = this;
             pic_id = pic_id.split("_");
             pic_id = pic_id[1];
             
            $.post(base_url+"manage/photos/del", {site_id: site_id, pic_id: pic_id}, function(data){
                
                 $.canToast(data);
                 picture.fadeOut('fast', function(){
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
                url: base_url+"manage/photos/add",
                type: 'POST',
                async: false,//istegin tamamlanmasini bekle yoksa dom hazir olmaz diger fonksiyon bind edemez
                data: {site_id: site_id},
                success: function(data){
                   $('#modal').html(data).children(':first-child').modal().on('hidden', function () {
                        $('#fileupload').fileupload('destroy');
                    });
                   if(_this.is_ie() < 10 && _this.is_ie() != false) {
                    _this.swf_upload();
                   } else {
                     _this.jquery_upload();                    
                   }
                   $loading.hide();
                   
                }
            })

       },
       serialize: function(){
           var _this = this;
              var $active = $('.active_pic');
              if($active.size() < 1){//eger hic secili foto yoksa false dön
                  return false;
              }
              var seri = "";
                $active.each(function(){
                  var pic_id = $(this).attr('id');
                  pic_id = _this.id_splitter(pic_id);
                  seri += 'photos[]='+pic_id+'&';
               });
               
               return seri;
       },
       jquery_upload: function() {
        var _this = this;
        var fileCount = 0, fails = 0, successes = 0;
        var options = _this.options;
        $('.fileupload-area').show();
        $('#fileupload').fileupload({
            dataType: 'html',
            acceptFileTypes: options.acceptFileTypes,
            maxFileSize: options.maxFileSize,
            paramName: 'Filedata',
            url: base_url+"manage/upload/doupload",
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progressbar div').css(
                    'width',
                    progress + '%'
                );
                $('#progressbar div').html(progress + '%');
            },
            fail: function(e, data) {
                fileCount++;
                if(fileCount == data.originalFiles.length) {
                    $('#progressbar').hide();
                    fileCount = 0;
                }
                $.canToast('<div class="error">'+lang.info_error_upload+'</div>' );
            },

            done: function (e, data) {
                var progress = 0;
                $('#progressbar div').css(
                    'width',
                    progress + '%'
                );
                $('#progressbar div').html(progress + '%');
                fileCount++;
                if(fileCount == data.originalFiles.length) {
                    $('#progressbar').hide();
                    fileCount = 0;
                }
                var serverData = data.result;
                $.each(data.files, function (index, file) {
                    if(serverData == 'storage_limit_error') {
                        $.canToast('<div class="error">Dosya yükleme limiti aşıldı. Lütfen bazı dosyaları silip tekrar deneyiniz.</div>');
                        return false;
                    };
                    $.canToast('<div class="success">'+lang.info_success_upload+' {' +file.name+'}</div>' );
                    
                    var imgsrc = $(serverData);
                    imgsrc.hide();
                    $('.pictures').prepend(imgsrc);
                    imgsrc.fadeIn('slow');
                    _this.active_but();
                });
            }
        }).on('fileuploadadd', function(e, data) {
                var error = 0;
                $.each(data.files, function (index, file) {          
                  if (options.acceptFileTypes &&
                      !(options.acceptFileTypes.test(file.type) ||
                        options.acceptFileTypes.test(file.name))) {
                      error = 1;
                      $.canToast('<div class="error">Bu dosya tipini yükleyemezsiniz. ('+file.name+')</div>' );
                  }else if(file.size > options.maxFileSize) {
                      error = 1;
                      $.canToast('<div class="error">Dosya boyutu büyük. ('+file.name+')</div>' );
                  }
                });
            data.context = $('<div/>').appendTo('#files');
            if(error == 0) {
              $('#progressbar').show();
            } else {
              fileCount++;
            }
                if(fileCount == data.originalFiles.length) {
                    $('#progressbar').hide();
                    fileCount = 0;
                }            
        });
       },
       swf_upload: function(){
        var _this = this;
        var options = _this.options;
        $('#swfupload-control').show();
	$('#swfupload-control').swfupload({
		upload_url: base_url+"manage/upload/doupload",
		file_size_limit : options.swfupload.file_size_limit,
		file_types : options.swfupload.file_types,
		file_types_description : lang.str_file_desc,
		file_upload_limit : "0",
		flash_url : base_url+"files/js/app/plugins/swfupload/swfupload.swf",
		button_image_url : base_url+'files/js/app/plugins/swfupload/upload-but.png',
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
			//$('#swfupload-control').after('<div class="progress-bar"><div></div></div>');
      $("#progressbar").show();
		})
		.bind('uploadProgress', function(event, file, bytes, total){
                    var percent = 100 * bytes / total;
                    percent = Math.round(percent); //yuvarlama
                    $("#progressbar div").animate({width: percent + "%"}, {duration: 500, queue: false}).html(percent+'%');                    
		})
		.bind('uploadSuccess', function(event, file, serverData){
		//	$('#log').append('<li>Upload success - '+file.name+'</li>');
                    $("#progressbar").hide();

                    if(serverData == 'storage_limit_error') {
                        $.canToast('<div class="error">Dosya yükleme limiti aşıldı. Lütfen bazı dosyaları silip tekrar deneyiniz.</div>');
                        return false;
                    };

                    $.canToast('<div class="success">'+lang.info_success_upload+' {' +file.name+'}</div>' );
                    
                    var imgsrc = $(serverData);
                    imgsrc.hide();
                    $('.pictures').prepend(imgsrc);
                    imgsrc.fadeIn('slow');
                    _this.active_but();
		})
		.bind('uploadComplete', function(event, file){
		//	$('#log').append('<li>Upload complete - '+file.name+'</li>');
			// upload has completed, lets try the next one in the queue
			$(this).swfupload('startUpload');
		})
		.bind('uploadError', function(event, file, errorCode, message){
                  $("#progressbar").hide();
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
