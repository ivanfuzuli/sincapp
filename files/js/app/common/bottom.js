define(['jquery'], function($) {
   return {
       init: function(){
           $('#bottom-bar').click(function() {
           	var $content = $('#bottom-content');
           	if($content.hasClass('hide')) {
           		$content.removeClass('hide').show();
				$('html, body').animate({scrollTop: $(document).height()}, 1000);
           	} else {
           		$content.slideUp(function() {
           			$content.addClass('hide');
           		});
           	};

           });
       }
}
});