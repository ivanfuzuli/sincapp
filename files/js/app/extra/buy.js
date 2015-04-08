define(['jquery', 'bootstrap', 'plugins/card', 'plugins/jquery.maskedinput.min'], function($){
   return{
       init: function(){
       	  $('body').prepend('<div id="buyModal"></div>');
          $("#phone").mask("(999) 999-9999");
          this.binder();
          if($('.card_wrapper').length > 0) {
              this.card_binder();
          }

          $('body').on('click', '.btn-print', function() {
              var html = $('.modal-body').html();
              var $iframe = $('<iframe id="print-iframe"/>').on('load',function(){
                var $contents = jQuery(this).contents();
                var encoding = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
                $contents.find('head').html(encoding);
                $contents.find('body').html(html);
                var frm = document.getElementById('print-iframe').contentWindow;
                frm.focus();// focus on contentWindow is needed on some ie versions
                frm.print();
              }); 
              $('#print-media').html('').append($iframe);

          });
       },
      detect_ie: function() {
            var ua = window.navigator.userAgent;
            var msie = ua.indexOf('MSIE ');
            var trident = ua.indexOf('Trident/');

            if (msie > 0) {
                // IE 10 or older => return version number
                return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
            }

            if (trident > 0) {
                // IE 11 (or newer) => return version number
                var rv = ua.indexOf('rv:');
                return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
            }

            // other browser
            return false;
        },

       card_binder: function() {
        var _this = this;
        var ie_version = _this.detect_ie();
        if(ie_version < 10 && ie_version != false) {
            $('.card_wrapper').hide();
        }        

        // setting $.card.values is one way to override
        // the default card values
        $.card.values = {
            number: '**** **** **** ****',
            name: 'İsim Soyisim',
            expiry: '**/****',
            cvc: '***'
        }

        $('#pay_form').card({
            container: '.card_wrapper',
            width: 350,
            // passing in a messages object is another way to 
            // override the default card values
            values: {
                number: '**** **** **** ****',
                name: 'İsim Soyisim',
                expiry: '**/****',
                cvc: '***'
            },
            messages: {
                validDate: 'valid\nthru', // optional - default 'valid\nthru'
                monthYear: 'ay/yıl', // optional - default 'month/year'
            }
        });

        $('#inputNumber, #inputExpiry, #inputCvc, #inputName').keypress(function() {
              var $elm = $(this);
              var $container = $elm.parent().parent();
              if($container.hasClass('error')) {
                $container.removeClass('error');
                $elm.next().fadeOut();                
              }
        });

        $('#inputAgreement').click(function() {
            $('#inputAgreement').parent().next().hide();
        });

        $('#pay_form').submit(function() {
          $('#inputNumber, #inputExpiry, #inputCvc, #inputName').each(function(index) {
              var _this = $(this);
              if(_this.val().length == 0) _this.addClass('card-invalid');
          });

            var statu = $('input.card-invalid').length;
            var error = false;
            if(statu) {
                error = true;
                $('input.card-invalid').next().css({'display': 'inline-block'}); 
                $('input.card-invalid').parent().parent().addClass('error');       
            } 

            if(!$('#inputAgreement').is(':checked')) {
                error = true;
                $('#inputAgreement').parent().next().css({'display': 'inline-block'}); 
            };

            if(error == false) {
                $('#btnPay').attr('disabled', 'disabled');
                $('#btnPay').html('Lütfen Bekleyin...');
            } else {
                return false;
            }
        });
       },

       binder: function() {
            var _this = this;
            $('body').on('click', '.buy-but', function(){
               var $but = $(this);
               var url = $but.attr('data-action');
               $but.button('loading');
               $.get(url, function(data){
                   $('#buyModal').html(data).children(":first-child").modal();
                   $but.button('complete');
                   //formu bind edelim
                   _this.filter();
                   _this.domainSearch();
               });

               return false;
            }); 

       },

       filter: function() {
		$('#domain').on('keypress', function (e) {
		    var txt = String.fromCharCode(e.which);

		    if (!txt.match(/[a-z0-9+-]/) && e.which != 8) {
		        return false;
		    }
		});   

		$('#domain').on('keyup', function(){
		    if($(this).val() != "") {
		    	$('#btn-search').removeAttr('disabled');
		    } else {
		    	$('#btn-search').attr('disabled', true);
		    }			
		});	
       },

       domainSearch: function() {
          $('body').on('click', '.btn-existing-domain', function() {
            var $this = $(this);
            $('#exist-notify').slideDown();
            var name = $this.data('name');
            var href = $this.data('href');
            $('#spanName').html(name);
            $('#btnContinue').attr('href', href);
          });
       		$('#domainSearch').submit(function() {
       			var $but = $('#btn-search');
       			var data = $(this).serialize();
       			var url = $(this).data('submit');
       			$but.button('loading');
       			$.post(url, data, function(data) {
       				$('#domainList').html(data);
       				$but.button('complete');
       			});
       			return false;
       		});
       }
   } 
});
