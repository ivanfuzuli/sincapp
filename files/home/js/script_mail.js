jQuery(document).ready(function($){
  "use strict";
  /* setting the url ro submit the mail */
  //form validation rules
  /* Error List to be displayed when recieved error via AJAX */
	var captcha_error = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Girmiş olduğunuz güvenlik kodu hatalı.</div>',
  full_name_error = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Lütfen isim soyisim alanını doldurunuz.</div>',
  sitename_error = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Lütfen geçerli bir site adresi girin!.</div>',
  sitename_exist = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Bu site ismi daha önce alınmış. Lütfen başka bir isim seçin.</div>',
  min_max_sitename_error = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Site adı en az 3 en fazla 25 karakterden oluşabilir.</div>',
  password_error = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Lütfen şifre seçin!.</div>',
  min_password_error = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Şifreniz en az 4 karakterden oluşabilir.</div>',
  email_exist = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Bu e-posta adresi zaten kullanımda!.</div>',
	email_error = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Sizinle iletişime geçebilmemiz için e-posta adresiniz gerekli.</div>',
	invalid_email_error = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>E-posta adresinizi isim@adres.com şeklide olmalıdır.</div>',
  invalid_sitename_error = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Site adı türkçe karakter(ğüşıöç) ve noktalama işaretleri ve boşluk içeremez. Sadece İngilizce karakterler ve rakamlardan oluşabilir.</div>',

	message_error = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Lütfen mesajınızı girin.</div>',	
	mail_error = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button>Mesajınız gönderilemedi! Lütfen tekrar deneyin.</div>',
	mail_success = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Mesajınız iletildi. Teşekkürler!</div>',
	phone_error = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Telefon numaranızı girin.</div>',	
	quote_mail_error = '<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button>Opps. Bir sorun oluştu. Lütfen daha sonra tekrar giriniz!</div>';
  
  jQuery.validator.addMethod("alphaspace", function(value, element) {
    return this.optional(element) || /^[a-zA-Z ]+$/.test(value);
  }, "Karakter alfanumerik olmalıdır.");
  
  jQuery.validator.addMethod("phonenumber", function(value, element) {
    return this.optional(element) || /^[0-9-]+$/.test(value);
  }, "Your Phone Number must be in the format of (111-1111-111 or only digits)");
  
  $(".contact_form form").validate({
    rules: {
      full_name: {
        required: true        
      },
      email: {
        required: true,
        email: true
      },
      message: "required",
    },
    messages: {
      full_name: {
        required: "Lütfen adınızı girin.",
      },
      email: {
        required: "Sizinle iletişim kurabilmemiz için e-posta adresiniz gereklidir.",
        email: "E-posta adresiniz isim@adres.com şeklinde olmalıdır."
      },
      message: "Mesajınızı girin"
    },
    submitHandler: function() {
      var form = $('.contact_form form');
      var full_name = form.find('[name="full_name"]').val();
      var email = form.find('[name="email"]').val();
      var message = form.find('[name="message"]').val();
      var _token = form.find('[name="_token"]').val();
     
      ContactAjax(full_name, email, message, _token);
    }
  });
  
  var ContactAjax = function($full_name, $email, $message, _token){
    var $btn = $('#btn_submit_contact');
    $btn.attr('disabled', 'disabled');
    $btn.val('Lütfen Bekleyin..');
    var url = base_url + "pages/do_contact";
    $.ajax({
      type: "POST",
      url: url,
      //dataType: "json" ,
      data: { full_name : $full_name, email : $email, message : $message, _token: _token},
      success: function(data) {
            $btn.removeAttr('disabled');
            $btn.val('Gönder');
        var response = jQuery.parseJSON(data);			
        $(".contact_form form .result .alert").slideUp().remove();
        var contact_form = $('.contact_form form');
        if(response.success)
        {   contact_form.slideUp().height('0');
         contact_form.parent().append(mail_success);
        }else{
          var i;
          for(i=0; i<response.errors.length; i++){
            if(response.errors[i].error == 'empty_name')  {
              contact_form.find('[name="full_name"]').parent().append(full_name_error);
            }
            if(response.errors[i].error == 'empty_email')  {
              contact_form.find('[name="email"]').parent().append(email_error);
            }
            if(response.errors[i].error == 'empty_message')  {            
              contact_form.find('[name="message"]').parent().append(message_error);
            }
            if(response.errors[i].error == 'invalid'){
              contact_form.find('[name="email"]').parent().append(invalid_email_error);  
            }
            if(response.errors[i].error == 'mail_error'){
              contact_form.append(mail_error);  
            }
          }
        }
        jQuery('button.close').click(function(){
          if(jQuery(this).data('dismiss')==='alert'){
            jQuery(this).parent().remove();
          }
        });
        
      }	
    });
  };
  
  /* Landing Page Form */
   $.validator.addMethod("loginRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
    }, "Sadece harf ve rakamlardan oluşabilir. (ü,ğ,ş,ı,ç,ö) kullanmayınız.");
    
  $(".free_quote_form form").validate({
    rules: {
      sitename: {
        required: true,
        loginRegex: true
        
      },
      email: {
        required: true,
        email: true
      },
      password: {
        required: true,
	minlength: 4

    }
    },
    messages: {
      sitename: {
        required: "Lütfen geçerli bir site adresi girin!",
	alphaspace: "Sadece ingilizce karakterler geçerlidir. Lütfen türkçe karakter (üğışçö) kullanmayın."
      },
      email: {
        required: "Lütfen geçerli bir e-posta adresi girin!",
        email: "E-posta adresi hatalı. Örn. isim@site.com olmalıdır!"
      },
      password: {
        required: "Lütfen şifre girin.",
	minlength: jQuery.format("Şifre en az {0} karakter olmalıdır!")
      }
    },
    submitHandler: function() {
      var form = $('.free_quote_form form');
      var sitename = form.find('[name="sitename"]').val();
      var email = form.find('[name="email"]').val();
      var password = form.find('[name="password"]').val();
      var _token = form.find('[name="_token"]').val();
      var phrase = form.find('[name="phrase"]').val();
      if (!phrase) {
        phrase = null;
      }
      QuoteAjax(sitename, email, password, _token, phrase);
    }
  });
  
  var QuoteAjax = function($sitename, $email, $password, _token, $phrase){
    var $btn = $('#btn_submit_quote');
    $btn.attr('disabled', 'disabled');
    $btn.val('Lütfen Bekleyin...');
    var url = base_url + "home/signup";
    if($phrase == null) {
      var data = { sitename : $sitename, email : $email, password : $password, _token: _token};
    } else {
      var data = { sitename : $sitename, email : $email, password : $password, _token: _token, phrase: $phrase};
    };
    $.ajax({
      type: "POST",
      url: url,
      //dataType: "json" ,
      data: data,
      success: function(data) {
        $btn.removeAttr('disabled');
        $btn.val('ÜCRETSİZ ÜYE OL!');
        //console.log(data);
        var response = jQuery.parseJSON(data);			
        $(".free_quote_form form .result .alert").slideUp().remove();
        var contact_form = $('.free_quote_form form');
        if(response.success)
        {
            window.location = base_url + "dashboard";
        }else{
          $btn.removeAttr('disabled');
          $btn.val('ÜCRETSİZ ÜYE OL!');
          var i;
          for(i=0; i<response.errors.length; i++){
            if(response.errors[i].error == 'captcha_error')  {
              contact_form.find('[name="phrase"]').parent().append(captcha_error);
            }
            if(response.errors[i].error == 'empty_sitename')  {
              contact_form.find('[name="sitename"]').parent().append(full_name_error);
            }
            if(response.errors[i].error == 'sitename_exist')  {
              contact_form.find('[name="sitename"]').parent().append(sitename_exist);
            }            
            if(response.errors[i].error == 'empty_email')  {
              contact_form.find('[name="email"]').parent().append(email_error);
            }
            if(response.errors[i].error == 'email_exist')  {
              contact_form.find('[name="email"]').parent().append(email_exist);
            }                         
            if(response.errors[i].error == 'min_max_sitename_error'){
              contact_form.find('[name="sitename"]').parent().append(min_max_sitename_error);  
            }
            if(response.errors[i].error == 'invalid_sitename'){
              contact_form.find('[name="sitename"]').parent().append(invalid_sitename_error);  
            }            
            if(response.errors[i].error == 'invalid'){
              contact_form.find('[name="email"]').parent().append(invalid_email_error);  
            }
            if(response.errors[i].error == 'min_password_error'){
              contact_form.find('[name="password"]').parent().append(min_password_error);  
            }            
            if(response.errors[i].error == 'mail_error'){
              contact_form.append(quote_mail_error);  
            }
          }
        }//
        jQuery('button.close').click(function(){
          if(jQuery(this).data('dismiss')==='alert'){
            jQuery(this).parent().remove();
          }
        });
        
      }	
    });
  };
  
  
});