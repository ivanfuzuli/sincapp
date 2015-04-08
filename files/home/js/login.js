$('#forgot-form').submit(function() {
	var url = $(this).attr('action');
	var $but = $('#forgot-submit');
	var val = $but.val();
	$but.attr('disabled', 'disabled');
	$but.val('Lütfen Bekleyin...');
	$.post(url, $(this).serialize(), function(response){
		$but.removeAttr('disabled');
		$but.val(val);
		$('#form-alert').html(response);
	});

	return false;
});

$('#login-form').submit(function() {
	var $but = $('#login-submit');
	$but.attr('disabled', 'disabled');
	$but.html('Lütfen Bekleyin...');
});

$('.refresh_captcha').click(function() {
   var stamp = new Date().getTime();
   var src = $(this).data('captcha');
  src = src+'?'+stamp;
        
  $('.captcha').attr('src', src);
  return false;
});