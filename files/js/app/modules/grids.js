define([
    'jquery', 
    'i18n!nls/grids.lang', 
    'helpers/loader', 
    'jqueryui', 
    'plugins/jquery.ui.resizeme', 
    'canTip', 
    'canToast',
    'plugins/jquery.ui.touch-punch'
], function($, lang, loader) {
   return {
    extBar: function(){
        $('body').on('mouseenter', '.ext', function(){
            clearTimeout($(this).data('timeout'));
       
            var element = $(this).find('.ext_bar');
            var timer = setTimeout(function(){
                element.slideDown();
   
            }, 300);
             $(this).data('timeout', timer);
        })
        
        $('body').on('mouseleave', '.ext', function(){
            
            if($(this).children().hasClass('on')){
                return false;
            }
            
            clearTimeout($(this).data('timeout'));
            
            var element = $(this).find('.ext_bar');
            var timer = setTimeout(function(){
                element.slideUp();
   
            }, 300);
           
           $(this).data('timeout', timer);

        });
   
    },
    
    init: function(){
            this.extBar();
            this.emptyElements();
            this.mergeGrids();
            this.dragging();
            this.rebinder();
    },
    rebinder: function(){
        var _this = this;
        var loading = $('#loading');    
        
        this.resizer();
        $("table.grids td:not(.dividerTd)" ).sortable({
        placeholder: 'extplaceholder',
	tolerance: 'pointer',
        scroll: true,        
        handle: 'h2',
        revert: 150,
        start: function(e, ui){
            $(document).disableSelection();//amk senin ie
            $('#middle').css('z-index', '102');
            
            $(this).sortable('refreshPositions');
            
            $('#black_area').fadeIn();            
        },

        stop: function(e, ui){
           $(document).enableSelection();//amk senin ie
            $('#middle').css('z-index', 'auto');
           
           $('body').css('cursor', 'auto');
          
           var $item = ui.item;
           var $parElement = $item.parent();
           var $parId = $parElement.attr('id');
            
           var devam = false;
           var ext_id;
           
            //sürükleme biter kararti gider
            $('#black_area').fadeOut();            
         
         //üst toolbardan yeni eleman yaratmaca
         if($item.hasClass('dragMe') == true){
             var ext_type = $item.attr('ext_type');
             
                loading.show();
                $.ajax({
                    type: 'post',
                    async: false,
                    data: 'site_id='+site_id+'&page_id=' +page_id+'&ext_type='+ext_type + '&prefix=' + prefix,
                    url: base_url + 'manage/extensions/set_ext',
                    success: function(my_json){ 
                        var json = $.parseJSON(my_json);
                        var statu = json.statu;
                                                 
                        if(statu == true){
                            ext_id = json.ext_id;
                            
                            $item.after(json.html);
                                                                                    
                            loader.canCallback(ext_type, ext_id);//callbacki çağır
                            //


                            devam = true;
                        }else{
                             $.canToast(json.err);   
                             devam = false;
                        }

                        $item.remove();
                        loading.hide();
                    }
               })
         }else{
             devam = true;
             ext_id = $item.attr('id');
             
             ext_id = ext_id.split('_');
             ext_id = ext_id[1];             
         }
          
         //devamı true ise yola devam 
         if(devam==true){   
   
            //basa yada sona -amk ya da ayrı yazılır neyse- sürükleme olursa yeni table olusturur
            if( $parId == "firstGrid" || $parId == "lastGrid" ){
                _this.newTable(ext_id, $parId);
                
            }else if($parElement.hasClass('empty')){
                 //bosa gelirse yeni grid olusturur
                 _this.newGrid($parElement, ext_id);

            }else{
                //sadece tasinacak isleme gerek yok sadece post et
                  _this.postGrid($parElement);
                    
            }
            }
        }
        }).sortable('option', 'connectWith', 'table.grids td:not(.dividerTd)');

    },
    serialize: function(element){
       //cocuklarini alalim
        var childs = element.children();
        //her cocugun idsini alip arraymizi yapalim
        var seri = "";
        childs.each(function(){
            
            var str = $(this).attr('id');
            str = str.split("_");
            seri += str[0]+'[]='+str[1]+'&';
        });

        return seri;   
    },
    //grid_12 u misal 12 ye ceviririm abiii
    convertId: function(str){
        str = str.split("_");
        return str[1];
    },
    
    postGrid: function(element){
        var data= this.serialize(element);
        var grid_id = this.convertId(element.attr('id'));
        var loading = $('#loading');
               //veritabanina isle
                loading.show();
                           $.ajax({
                            type: 'post',
                            data: data+'&site_id='+site_id+'&grid_id='+grid_id,
                            url: base_url + 'manage/grids/sort',
                            success: function(data){  
                                $.canToast(data);
                                loading.hide();
                            }
                           })
    },
    
    dragging: function(){
    var middleTop = 0;
		$( ".dragMe" ).draggable({
                        cursor: 'move',
                        appendTo: 'body',
                        scroll: true,
			helper: "clone",
			revert: "invalid", 
                          start: function(e, ui){

                            $(document).disableSelection();//amk senin ie
                            $('#middle').css('z-index', '102');
            
            //tasinan nesneye özel bir class verelim ve body'ye entegre edelim yoksa bug olur üzülürüz 
                              //$(ui.helper).addClass('lidragging');
                              $(ui.helper).appendTo('body');
                              
                               $('body').css('cursor', 'move');
                               $('#black_area').fadeIn();
                               $('#dragHelp').fadeIn();
                               middleTop = $('#middle').offset().top;
                           },
                           drag: function (e, ui) {
                               if ($(ui.helper).offset().top > middleTop) {
                                  $('#dragHelp').fadeOut();
                               } else {
                                  $('#dragHelp').fadeIn();
                               }
                           },

                        stop: function(e, ui){
                               $('body').css('cursor', 'auto');
                               $('#black_area').fadeOut();
                              $('#dragHelp').fadeOut();
                            $(document).enableSelection();//amk senin ie
                            $('#middle').css('z-index', 'auto');
                              
                        }
		}).draggable('option', 'connectToSortable', 'table.grids td:not(.dividerTd)');
           
                    
    },
    newTable: function(ext_id, parId){
        var _this = this;
        var $loading = $('#loading');
          var tr = '<table class="grids"><tr class="parent_grid"><td class="grid" id="grid_new" style="width: '+930+'px"></td></tr></table>';
          var dividerTd = $('.dividerTd').first().clone().removeClass('hideDivider');
          var empty = $('<td class="empty grid">'+lang.str_drag_drop_here+'</td>').css({'width': 0, 'display':'none'});
       //basa eklerse basa yarat sona eklerse sona yarat
       if(parId == "firstGrid"){
            $('.grids').first().after(tr);
        }
       if(parId == "lastGrid"){
            $('.grids').last().before(tr);
        } 
        
        $('#grid_new').after(empty);       
        $('#grid_new').after(dividerTd);       
        
        $('#ext_'+ext_id).prependTo('#grid_new');
        
        $loading.show();
        $.post(base_url+"manage/grids/new_table", {site_id: site_id, page_id: page_id, ext_id: ext_id, parId: parId}, function(grid_id){

                $('#grid_new').attr('id', 'grid_'+grid_id);   

                  //tekrar bind et herseyi
                  _this.rebinder();
                  $loading.hide();
             });         
    },
    
    newGrid: function(parElement, ext_id){
        var _this = this;
        var $loading = $('#loading');
        //bir önceki idyi al gönder kii yeni yerini bilsin sabiii
                var before_id = parElement.prev().prev().attr('id');
                before_id = _this.convertId(before_id);

                //ayrac kopyala
                var dividerTd = parElement.prev().clone();
                var width = parElement.width() - 30;//30 dividerTd boyu
                var td = '<td class="grid" id="grid_new" style="width: '+width+'px"></td>';

                parElement.before(td);         
                parElement.before(dividerTd);
                
                $('#ext_'+ext_id).appendTo('#grid_new');

                parElement.css({'width': 0, display:'none'});
                //tekrar bind et bakiim
                _this.rebinder();
                
                $loading.show();
                //bilgileri sunucuya gönder yeni eleman var deyuu
                $.post(base_url+"manage/grids/new_grid", {site_id: site_id, before_id: before_id, ext_id: ext_id, width: width}, function(grid_id){
                   $('#grid_new').attr('id', 'grid_'+grid_id);
                   $loading.hide();
            });           
    },
    
    resizer: function(){
        $('.dividerTd').resizeMe();
    },
    
    emptyElements: function(){
        $('.parent_grid').each(function(){
              var width = 960;//960px ie7 bugfix 
              var display = "table-cell";
              $(this).children().each(function(){
                  width -= $(this).width();
              })
              if(width < 30){
                  display = "none";
              }
             $(this).append('<td class="empty grid" style="width:'+width+'px; display:'+display+'">'+lang.str_drag_drop_here+'</td>');
          });             
    },
    
    mergeGrids: function(){
    //birlestirici
    var _this = this;
    $('body').on('click', '.mergeMe', function(){
        var answer = confirm(lang.confirm_merge);
	if (!answer){
            return false;
	}
        //elemanlar üst basamak olduğu için bir üste çık dom da
        var element = $(this).parent();
        //yeri degistirilecek eleman önceki, ve sonraki
        var before = element.prev();
        var after = element.next();
        var childs = before.children();
       
       var childlen = childs.length;
       //ikisinin toplam uzunlugu yyeni elemanin uzunlugu olacak
        var totalWidth = before.innerWidth() + after.innerWidth() + element.innerWidth();
       
        var empty_grid = "delete";
        //en son kutu degilse islemler iyap
        if(!after.hasClass('empty')){
        //tasimaca
        childs.appendTo(after);
        
        element.remove();
        before.remove();
        after.css('width', totalWidth);
       }else{
           //en son kutuysa
         //bu veritabanina gidecek
         if(childlen=="0"){
             
         
         //cocuk yoksa sil bebek
         empty_grid = "nochild";

         before.remove();
         after.prev().remove();
         
         after.css('width', totalWidth);
         after.css('display', 'table-cell');
         
         //bombos bir eleman olursa deyu bunu yap bebek
         if(after.parent().children().length == 1){
             after.parent().remove();
         }
         
         }else{
             //cocuk var o zaman silme de boyutunu degistir
         empty_grid = "stop";
         before.css('width', totalWidth);
         after.css({'width': 0, 'display':'none'});
          }
       }
       var before_id = _this.convertId(before.attr('id'));
       
       var after_id = 0;
       if(after.attr('id') != undefined){
       after_id = _this.convertId(after.attr('id'));
       }
       
       var $loading = $('#loading');
       //veritabanina isle
       $loading.show();
        $.post(base_url+"manage/grids/merge", {site_id: site_id, before_id: before_id, after_id: after_id, width: totalWidth, empty: empty_grid}, function(data){
           //bilgilendirme mesaji
            $.canToast(data);
            $loading.hide();
        } );

    })        
    }          
   }
});


