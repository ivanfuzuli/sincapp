define(['jquery', 'bootstrap'], function($){
    return{
    init: function(){
        this.slider();
        this.enable_signup_but();
        this.disable_login_but();
        this.signup_binder();
        this.popover_binder();
    },
    
    popover_binder: function() {
       $('#sitename').popover({
          trigger: 'focus', 
          title: 'İpucu!', 
          content: 'Site adı http://<b>siteadi</b>.sincapp.com/ halini alacaktır. Lütfen türkçe karakterler <b>[üğşçöı]</b> kullanmayınız. ',
          placement: 'left',
          template: '<div class="popover popover-margin"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>'
        });

       $('#email').popover({
          trigger: 'focus', 
          title: 'İpucu!', 
          content: 'Lütfen geçerli bir e-posta adresi giriniz. Şifrenizi unutmanız durumunda bu e-posta adresi kullanılacaktır. ',
          placement: 'left'
       });

       $('#password').popover({
          trigger: 'focus', 
          title: 'İpucu!', 
          content: 'Lütfen en az 4 karakterden oluşan bir şifre giriniz. ',
          placement: 'left'
       });       
    },

    enable_signup_but: function(){
        //jquery yüklenene kadar buton deaktif
        $('#signup-but').removeAttr('disabled');
    },
    
    slider: function(){
        $('#sliderMe').carousel({
            interval: 7000
        });        
    },
    
    //login butona tiklayinca buton disabled olsun
    disable_login_but: function(){
        $('#login-form').submit(function(){
            $('input[type=submit]', this).attr('disabled', 'disabled');
        });        
    },
    
    //kayit islemleri
    signup_binder: function(){
        $('#signup-form').submit(function(){
           var $elm = $(this);
           var $but = $('input[type=submit]', this);
           var url = $elm.attr('data-action');
           
           $but.button('loading');
           $('#errors').hide();
           var f_data = $(this).serialize();
           $.ajax({
              type: 'post',
              url: url,
              data: f_data,
              success: function(data) {
                var json = $.parseJSON(data);
                $but.button('complete');                 
                if(json.statu == 1){//kayit tamamlandi yonlendir
                     window.location = json.url;                
                }else{//hata var isle
                    $('#errors').html(json.str).fadeIn();
                }
              }
        });
           return false;
        });        
    }
   }  
});