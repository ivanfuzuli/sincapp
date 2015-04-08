define(['jquery'], function(){    
return{
    
    init: function(){
        this.popup_binder();
        this.placeholder();
        this.contact_do_binder();
        this.forgot_do_binder();

    },
    
    placeholder: function(){
        window.setInterval(function(){
        
        //autofill bugfix
        $('.placeholding-input').find('input').each(function(){
            var $elm = $(this);
            if($elm.val().length != 0){
                $elm.next().hide();
            }
        });
        }, 1000);
        
        $('.placeholder').click(function(){
            $(this).prev().focus();
        });

        $('.placeholding-input').find('input').focus(function(){
            $(this).next().css({'color': '#d1d1d1'});
        }).blur(function(){
            var $elm = $(this).next();
            $elm.css({'color': '#999'});
            if($(this).val().length == 0){
                $elm.show();
            }
        }).keypress(function(e){
            $(this).next().hide();
        }) 
    },    
    //iletisim formu gonder
    contact_do_binder: function(){
        
      $('body').on('submit', '#contact-form', function(){
          var $elm = $(this);
          var $but = $('input[type=submit]', this);
          var values = $elm.serialize();
          var url = $elm.attr('data-action');
          $but.button('loading');
            $('#contact-alert').hide();
            $.post(url, values, function(data) {
                $('#contact-alert').html(data).fadeIn();
                $but.button('complete'); 
                    
                    //form temizleme
                    $(':input', $elm)
                    .not(':button, :submit, :reset, :hidden')
                    .val('');
            });
          return false;
      });        
    },
    
    //linkleri popup acmaca
    popup_binder: function(){
        $('<div id="modalArea" />').appendTo('body');
        $('a[data-url]').click(function(){
            var url = $(this).attr('data-url');
            $('#loading').show();
            $.get(url, function(data) {
                $('#loading').hide();
                
                $('#modalArea').html(data).children(":first-child").modal();
            });   

            return false;
        });
       
    },

    //sifremi unuttumu isle
    forgot_do_binder: function(){
      $('body').on('submit', '#forgot-form', function(){

          var $elm = $(this);
          var $but = $('input[type=submit]', this);
          var values = $elm.serialize();
          var url = $elm.attr('data-action');
          $but.button('loading');
            $('#form-alert').hide();
            $.post(url, values, function(data) {
                $('#form-alert').html(data).fadeIn();
                $but.button('complete'); 
            });
          return false;
      });        
    }  
    
};

});