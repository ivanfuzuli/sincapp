define(['jquery', 'bootstrap', 'canTip', 'plugins/jquery.mousewheel', 'plugins/perfect-scrollbar'], function($) {
   return {
       cache: {},
       init: function(){  
           var _this = this;
           _this.mouse_events();
           _this.on_resize();
           _this.bind_switcher();
           _this.bind_cache();
           _this.bind_scroll_to();
           $('#left-area').perfectScrollbar();

           $(window).resize(function() {
              _this.on_resize();
              _this.bind_cache();
           })
           $('.dragMe').canTip({html: 'Lütfen bu elementi sağ tarafa sürükleyip bırakın.'});
           $('#btn-basic').canTip({html: 'Temel elementlere git.'});
           $('#btn-arch').canTip({html: 'Mimari elementlere git.'});
           $('#btn-blog').canTip({html: 'Blog elementlerine git.'});
           $('#btn-media').canTip({html: 'Medya elementlerine git.'});

       },
       bind_cache: function() {
          var _this = this;
          $('#left-area').scrollTop(0);
          $('.scrollto').each(function() {
              var target = $(this).data('target');
              _this.cache[target] = $($(this).attr('href')).position().top;
          })
       },

       bind_scroll_to: function() {
           var _this = this;
           $('.scrollto').click(function() {
            var elm = $(this).data('target');
            var top = _this.cache[elm];
            $('#left-area').animate({
                scrollTop:  top
            }, 1000);   
              return false;
           });

           $('#left-area').scroll(function() {
              var top = $('#left-area').scrollTop() + 50;
              $.each(_this.cache, function(item, value) {
                  if(value <= top) {
                      var $elm = $('#btn-' + item).parent();
                      if(!$elm.hasClass('active-scroll')) {
                        $('.active-scroll').removeClass('active-scroll');
                        $elm.addClass('active-scroll');
                      }
                  }
              });
           });
       },
       bind_switcher: function() {
            $('body').on('change', '#page-switcher', function() {
                var val = $(this).val();
                var url = base_url + 'manage/editor/wellcome/' + site_id + '/' + val + '.html';
                window.location = url;
            });
       },

       on_resize: function() {
            var statu = $('#left-area').hasClass('minified');
            if($(window).width() < 1200 && statu == false) {
                $('body').animate({marginLeft: '50px'});
                $('#left-area').animate({width: '50px'});
                $('#scrollnav').animate({width: '50px'});
                $('#left-area').addClass('minified');         
            }

            if($(window).width() > 1200 && statu == true) {
                $('body').animate({marginLeft: '250px'});
                $('#left-area').animate({width: '250px'});
                $('#scrollnav').animate({width: '250px'});
                $('#left-area').removeClass('minified');         
            }            
       },

       mouse_events: function() {
            $('#scroll-area').hover(function() {
                clearTimeout($(this).data('timeout'));
                if($('#left-area').hasClass('minified')) {
                  $('body').animate({marginLeft: '250px'});
                  $('#left-area').animate({width: '250px'});
                  $('#scrollnav').animate({width: '250px'});                  
                }
            },
            function() {
              var t = setTimeout(function() {
                if($('#left-area').hasClass('minified')) {
                  $('body').animate({marginLeft: '50px'});
                  $('#left-area').animate({width: '50px'});
                  $('#scrollnav').animate({width: '50px'});              
                } 
              }, 500);
              $(this).data('timeout', t);             
            })
       }
   }
});