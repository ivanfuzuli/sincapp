define(['jquery', 'bootstrap', 'colorbox'], function($){

return{
    init: function(){
      //eger tema sayfasindaysa bind et
      if($('#themeTopBar').length > 0){
          this.binder();
      }
    },
    
    resizer: function(){
    var winHeight =  $(window).height();
    var barHeight = $('#themeTopBar').height();
    var height = winHeight - barHeight;

    $('#theme-frame').css({'height': height}) ;          
    },
    
    binder: function(){
        var _this = this;
        $(window).resize(function(){
            _this.resizer();
        });    
    $('.glassBut').colorbox();
    
    $('.selectBut').click(function(){
        $('.btn-success').removeClass('btn-success');//pasif
        $(this).addClass('btn-success');//bu aktif
        
    });        
    }
}
});
