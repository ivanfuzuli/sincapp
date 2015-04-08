define([
    'jquery', 
], function($) {
	return {
		init: function() {
			var _this = this;
			_this.wrap();
			$('body').addClass('js-ready');
			$('window').resize(function() {
				_this.wrap();
			});
		},

	wrap: function() {
			var _this = this;
			var $element  =  $('#nav_bar');
			var width = 0;
			var bar_width = $element.width();
			var $last_item = null;
			if('prefix' == 'en') {
				var text = "More...";
			} else {
				var text = "Dahası...";
			}

			$element.append('<li class="more"><a href="#">' + text + '</a></li>');
			var $more = $('.more');
			width = $more.outerWidth(true);

			// Get outer width of total items
			$element.find('li').each(function(index, elm) {
				var $elm = $(elm);
				var $parent = $(elm).parent();
				if($parent.is('ul') && $parent.attr('id') != 'nav_bar') {
				} else {
					width += $(elm).outerWidth(true);
					if(width >= bar_width && $last_item == null) {
						$last_item = $(elm);
					}
				}
			});
			// \ Get outer width of total items
			$('.more').remove();// remove item which created for compute total element width

			if($last_item != null) {
				// Wrap
				var $my_elements = $last_item.nextAll().andSelf();
				$my_elements.wrapAll('<li class="more">').parent().prepend('<a href="#" class="more_link">'+text+'</a>');
				$my_elements.wrapAll('<ul class="more_ul"/>');
			};

		}		
	}
});