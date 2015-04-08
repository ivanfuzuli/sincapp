define([
    'jquery', 
    'helpers/toolbar', 
    'canTip', 
    'canToast',
    'jquery_tinymce'
], function($, toolbar){
    
    return{
      firstRun: function(ext_id) {
          var elm = '#ext_' + ext_id + ' .paragraphs';
          this.bind_tinymce(elm);
      },
      init: function(){
          this.binder();
          tinyMCE.baseURL = base_url + 'files/js/app/plugins/tinymce';
          tinyMCE.suffix = '.min';
          this.bind_tinymce('.paragraphs'); 
      },
      
      bind_tinymce: function(element) {
          $(element).tinymce({
                  inline: true,
                  language: 'tr_TR',
                  relative_urls : false,
                  remove_script_host : false,
                  convert_urls : true,
                  theme_advanced_resizing : true,
                  plugins: [
                      "hr textcolor autolink lists link image print anchor",
                      "searchreplace visualblocks code",
                      "media table contextmenu paste"
                  ],
                  toolbar: "insertfile undo redo |  fontsizeselect styleselect | link unlink media imagebutton | bold underline italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor",
                  setup: function(ed) {
                     ed.addButton('imagebutton', {
                          title : 'Fotograf Ekle',
                          image : base_url + 'files/js/app/plugins/tinymce/img/photo-icon.png',
                          onclick : function() {
                              // Add you own code to execute something on click
                              toolbar.photo_callback();
                          }
                      });

                      ed.on('ObjectResized', function(e) {
                        var target = $(e.target).prop("tagName");
                        if(target != 'IMG'){
                          return false;
                        };
                        
                        var $element = $(e.target);
                        var p_pic_id = $element.attr('data-p_pic_id');
                        var width = e.width;
                        var height = e.height;
                        var src = $element.attr('src');
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
                      });

                  }
          });
      },

      binder: function(){
        var _this = this;
        $('body').on('click', '.paragraphs', function(){
           $(this).focus(); //opera bug fix
        });
        $('body').on('focus', '.paragraphs', function(){

            var $element = $(this);
            $('#black_area').fadeIn();

            //eger bi kere yaratilmisa bi daha yaratma
            if($element.hasClass('editing')){
                return;
            } 

            var $parElement = $element.parent();
            var body = $('body')[0];
            $.data(body, 'elementId', $element.attr('id'));


            $('#black_area').one('click', function(){
               _this.update(); 
            });        
        
            $element.addClass('editing');
            $('#black_area').fadeIn();
            $parElement.addClass('on');
            //eski icerigi arsivleyelim ki iptal ederse geri bunu bassin
            $(this).find('.par_holder').remove();//placeholderimizi kaldiralim    

        });
        },
        
        cancel: function(){
            $('.editing').each(function(){
               var $elm = $(this);
               $elm.html($.data($elm[0], 'cache'));
               //bosalt
               $.data($elm[0], 'cache', '');
            });
            this.restore();
        },
        //kaydet
        update: function(){
            var $loading = $('#loading');
            
            $('.editing').each(function(){   
                var $element = $(this);     
                 //simdi datayi isle ve gönder
                var par_id = $element.attr('id');
                par_id = par_id.split('_');
                par_id = par_id[1];
                $element.find('.ui-resizable').resizable('destroy');
                var data = $element.html();
                $loading.show();
                       //veritabanina isle
                $.post(base_url+"manage/paragraphs/set_html", {site_id: site_id, page_id: page_id, paragraph_id: par_id, html: data}, function(data){
                   //bilgilendirme mesaji
                    var myJson = $.parseJSON(data);
                    $.canToast(myJson.info);
                    $element.html(myJson.content);
                    $loading.hide();
                });
            });
            this.restore();            
        },
        //toolbari zarti zurtu kapat
        restore: function(){
            var $elm = $('.editing');
            var $parElm = $elm.parent();

             $elm.removeClass('editing');
             $('#black_area').fadeOut();
             $parElm.removeClass('on');

             $parElm.parent().find('.ext_bar').slideUp();
        }
    }
});