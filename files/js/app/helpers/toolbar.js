define(['i18n!nls/toolbar.lang', 'helpers/photos', 'plugins/jquery.simplecolorpicker'], function(lang, photos) {
   var savedRange;//paste bug fixer

   return {
       init:function(){

       },
       insert_video: function(sUrl) {
          var ytRegExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
          var ytMatch = sUrl.match(ytRegExp);

          var igRegExp = /\/\/instagram.com\/p\/(.[a-zA-Z0-9]*)/;
          var igMatch = sUrl.match(igRegExp);

          var vRegExp = /\/\/vine.co\/v\/(.[a-zA-Z0-9]*)/;
          var vMatch = sUrl.match(vRegExp);

          var vimRegExp = /\/\/(player.)?vimeo.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/;
          var vimMatch = sUrl.match(vimRegExp);

          var dmRegExp = /.+dailymotion.com\/(video|hub)\/([^_]+)[^#]*(#video=([^_&]+))?/;
          var dmMatch = sUrl.match(dmRegExp);

          var $video;
          if (ytMatch && ytMatch[2].length === 11) {
            var youtubeId = ytMatch[2];
            $video = $('<iframe>')
              .attr('src', '//www.youtube.com/embed/' + youtubeId)
              .attr('width', '640').attr('height', '360');
          } else if (igMatch && igMatch[0].length > 0) {
            $video = $('<iframe>')
              .attr('src', igMatch[0] + '/embed/')
              .attr('width', '612').attr('height', '710')
              .attr('scrolling', 'no')
              .attr('allowtransparency', 'true');
          } else if (vMatch && vMatch[0].length > 0) {
            $video = $('<iframe>')
              .attr('src', vMatch[0] + '/embed/simple')
              .attr('width', '600').attr('height', '600')
              .attr('class', 'vine-embed');
          } else if (vimMatch && vimMatch[3].length > 0) {
            $video = $('<iframe webkitallowfullscreen mozallowfullscreen allowfullscreen>')
              .attr('src', '//player.vimeo.com/video/' + vimMatch[3])
              .attr('width', '640').attr('height', '360');
          } else if (dmMatch && dmMatch[2].length > 0) {
            $video = $('<iframe>')
              .attr('src', '//www.dailymotion.com/embed/video/' + dmMatch[2])
              .attr('width', '640').attr('height', '360');
          } else {
            // this is not a known video link. Now what, Cat? Now what?
          }
          if ($video) {
            $video.attr('frameborder', 0);
            var video = this.obj_to_s($video);
            tinyMCE.execCommand('mceInsertContent', false, video);

          }
       },
       //diyalog acildiktan sonra bind eet
       photo_callback: function(){
        var _this = this;
        photos.add();   //diyalog ac

         $('#photoForm').submit(function(){
            var $but = $(this).find('[type=submit]');
            var body = $('body')[0];
            var paragraphId = $.data(body, "elementId");
            paragraphId = photos.id_splitter(paragraphId);

            var seri = photos.serialize(); //secili photo idleri seriye döker
            if(seri == false){
                $.canToast('<div class="error">'+lang.err_select_photo+'</div> ');
                return;
            }

            $but.button('loading');
            _this.send_to_backend(paragraphId, seri);//simdi ise
            return false;
         });
       },

       blog_photo_callback: function() {
        var _this = this;
        photos.add();   //diyalog ac
         $('#photoForm').submit(function(){
            var $but = $(this).find('[type=submit]');

            var seri = photos.serialize(); //secili photo idleri seriye döker
            if(seri == false){
                $.canToast('<div class="error">'+lang.err_select_photo+'</div> ');
                return;
            }

            $but.button('loading');
            _this.send_to_blog_backend(seri);//simdi isle
            return false;
         });        
       },
       send_to_blog_backend: function(photos){
           var _this = this;
           var blog_id = $('#post_blog_id').val();
            $.ajax({
                type: 'post',
                data: photos+'&site_id='+site_id + '&blog_id=' + blog_id,
                url: base_url + 'manage/blog/photo',
                success: function(data){
                    var JSON = $.parseJSON(data);
                    //eski yerine getir imleci
                    _this.restoreSelection();
                    //simdi seri halde isleyelim
                    $.each(JSON.photos, function(i, photo){
                        var img = '<img src="' +photo.path+ '" data-blog_pic_id="'+photo.blog_pic_id+'" />';

                        tinyMCE.execCommand('mceInsertContent', false, img);
                    });
                    $('#photoForm').modal('hide');
                }
            });
       },       
       send_to_backend: function(paragraph_id, photos){
           var _this = this;
            $.ajax({
                type: 'post',
                data: photos+'&site_id='+site_id+'&paragraph_id='+paragraph_id,
                url: base_url + 'manage/paragraphs/photo',
                success: function(data){
                    var JSON = $.parseJSON(data);
                    //eski yerine getir imleci
                    _this.restoreSelection();
                    //simdi seri halde isleyelim
                    $.each(JSON.photos, function(i, photo){
                        var $img = $(document.createElement('img'));
                        $img.css({'float':'left'})
                            .attr('src', photo.path)
                            .attr('data-p_pic_id', photo.p_pic_id)
                            .attr('data-ratio', photo.ratio);

                        var img = '<img src="' +photo.path+ '" data-p_pic_id="'+photo.p_pic_id+'" />';

                        tinyMCE.execCommand('mceInsertContent', false, img);
                    });
                    $('#photoForm').modal('hide');
                }
            });
       },
    obj_to_s : function(obj) {
        var tmp = jQuery('<div>');
        jQuery.each(obj, function(index, item){
            if(!jQuery.nodeName(item, "script")){
                tmp.append(item);
            }
        });
        return tmp.html();
    },
       resizableImg: function($element){
         var ratio = $element.attr('data-ratio');
         var src = $element.attr('src');

         $element.resizable({
            //aspectRatio: ratio,
            create: function(e, ui){
                var left = $element.css('float');//left ya da right
                $(e.target).css({'z-index': 1000, 'float': left});
            },
            start: function(){
                  $(document).disableSelection();//amk senin ie
            },

            stop: function(e, ui){
                $(document).enableSelection();//amk senin ie
                var p_pic_id = $element.attr('data-p_pic_id');
                var width = $(this).width();
                var height = $(this).height();
                    $.post(base_url+"manage/paragraphs/resize", {site_id: site_id, p_pic_id: p_pic_id, width: width, height: height}, function(data){
                       $.canToast(data);
                       //yeniden boyutlandirilmis halini al
                       var newSrc;
                       var stamp = new Date().getTime();
                       var srdata = src.split('?');//fazla soru isareti olmasin
                       if(srdata[0]){//eger soru isareti varsa
                           newSrc = srdata[0]+'?'+stamp;
                       }else{
                           newSrc = src+'?'+stamp;
                       }
                       $element.attr('src', newSrc);
                    });
            }
	 });

       },

       videoEditor: function(){
            var body = $('body')[0];
            var elementId = $.data(body, "elementId");

            var _this = this;
            this.saveSelection();

            var _this = this;
           var str = '<form class="modal fade" name="toolVideoForm" id="toolVideoForm" action="#" method="post">';
           str += '<div class="modal-header"><a class="close" data-dismiss="modal">×</a><h3>Video Ekle</h3></div>';
           str += '<div class="modal-body">';
           str += '<input type="text" id="videoUrl" class="htmleditor" value="http://"/>';
           str += "Desteklenen siteler: Youtube, vimeo, instagram, dailymotion"
           str += '</div>';
           str += '<div class="modal-footer"><a class="btn" data-dismiss="modal">'+lang.but_close+'</a>';
           str += '<input type="submit" class="btn btn-primary" value="Ekle"/>';
           str += '</div></form>';

          $('#modal').html(str).children(':first-child').modal();

          $('#toolVideoForm').submit(function(e){
              e.preventDefault();
              var url = $('#videoUrl').val();
              _this.restoreSelection();
              _this.insert_video(url);
              $('#' + elementId).fitVids();
              $('#toolVideoForm').modal('hide');
          });
        },


    saveSelection: function()
    {
            var body = $('body')[0];
            var elementId = $.data(body, "elementId");
            $('#'+elementId).focus();
        if(window.getSelection)//non IE Browsers
        {
            savedRange = window.getSelection().getRangeAt(0);
        }
        else if(document.selection)//IE
        {
            savedRange = document.selection.createRange();
        }
    },
    restoreSelection: function()
    {
        if (savedRange != null) {
            if (window.getSelection)//non IE and there is already a selection
            {
                var s = window.getSelection();
                if (s.rangeCount > 0)
                    s.removeAllRanges();
                s.addRange(savedRange);
            }
            else
                if (document.createRange)//non IE and no selection
                {
                    window.getSelection().addRange(savedRange);
                }
                else
                    if (document.selection)//IE
                    {
                        savedRange.select();
                    }
        }
    },

   }

});
