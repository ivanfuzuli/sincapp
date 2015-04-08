define(['jquery', 'jqueryui'], function(jQuery){
/* 
/* ui resize for mee - can kucukyilmaz 2012
 */  
(function($) {  

  $.widget("ui.resizeMe", $.ui.mouse,  {  
  
    options: {

        starX: null,
        element: null,
        nextElement: null,
        elWidth: null,
        nextWidth: null,
        maxSize: null
    },  
    
    _create: function() {
        //fareyi yakala
      this._mouseInit(); 

    },  
  
    _mouseStart: function(e) {
       // $('#black_area').fadeIn();

        var o = this.options;
        //ilk pozisyonu kayıt edelim ki bilelim neredeymiş
        o.startX = e.pageX;
        //toplam hareket alani ve elemanlar
        $('body').css('cursor', 'e-resize');
        $('#black_area').fadeIn();
        $('#middle').css('z-index', '102');
        
        o.element = this.element.prev();
        o.nextElement = this.element.next();
        
        o.elWidth = o.element.width();
        o.nextWidth = o.nextElement.width();
        o.maxSize = o.elWidth + o.nextWidth - 100;
        

        
    },  
  

    _mouseDrag: function(e) {  
        var o = this.options;

        //yeni uzunluk
        var fark = e.pageX - o.startX;
        var elWidth = o.elWidth + fark;
        
        if(o.maxSize > elWidth && elWidth > 100){
            //animasyonumsu
            o.element.removeClass('minLimit');
            o.nextElement.removeClass('minLimit');
            
            
            //sonraki eleeman bossa
            if(o.nextElement.hasClass('empty')){
                o.nextElement.css('display', 'table-cell');
            }
            o.element.css('width', elWidth);
            o.nextElement.css('width', o.nextWidth - fark);        
            //hizli mouse kullanimi icin fix
            //
            //bu da eger sonraki eleman bosa onu gizlemek icin
        }else if(elWidth > o.maxSize && o.nextElement.hasClass('empty')){
            o.element.css('width', o.maxSize + 100);
            
            o.nextElement.css({'width': 0, 'display':'none'});  
            
        }else if(elWidth > o.maxSize){
            o.element.css('width', o.maxSize);
            o.nextElement.css('width', 100);  
            
            o.nextElement.addClass('minLimit');            
            
        }else if(elWidth < 50){
            o.element.css('width', 100);
            o.nextElement.css('width', o.maxSize);    
            
            o.element.addClass('minLimit');

        }

        },  

    _mouseStop: function(){
              var o = this.options;
             //animasyonumsu normale dön
            o.element.removeClass('minLimit');
            o.nextElement.removeClass('minLimit');
            
                //mouse normal işarete getir
                $('body').css('cursor', 'auto');

                $('#black_area').fadeOut();
                $('#middle').css('z-index', 'auto');


    //          $('#black_area').fadeOut();
            //yeni uzunlukları kayıt edelim
            var data = "";

            o.element.parent().children().each(function(){
                if(!$(this).hasClass('dividerTd')&&!$(this).hasClass('empty')){
                    //grid_112 dan 112 yi almaca
                    var grid_id = $(this).attr('id');

                    var str = grid_id.split("_");
                    grid_id = str[1];
                    
                    data += 'width['+grid_id+']'+'='+$(this).width()+'&'; 
                    
                }
            });
                var $loading = $('#loading');
                $loading.show();
            	$.ajax({
                    type: 'post',
                    data: data+'site_id='+site_id,
                    url: base_url + 'manage/grids/set_width',
                    success: function(data){
                        $.canToast(data);
                        $loading.hide();
                    }
                })

   
    },

    destroy: function() {}  
  });  

})(jQuery);  
});