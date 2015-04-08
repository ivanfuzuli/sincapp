define(['jquery', 'bootstrap'], function($){
   return{
       init: function(){
 			$('body').on('click', '.mail-but', function() {
                var $but = $(this);
                var url = $but.attr('data-action');
                $but.button('loading');
                $.get(url, function(data) {
                      $but.button('complete');
                      $('#modalArea').html(data).children(":first-child").modal();
                }); 

                return false;
 			});

 			$('body').on('submit', '#addMail', function() {
 				var data = $(this).serialize();
 				var $but = $('#addMailBut');
 				var url = $(this).data('action');
 				$but.button('loading');

 				$.post(url, data, function(response) {
 					$but.button('complete');

 					var json = $.parseJSON(response);
 					if (json.error) {
 						$('#mailAlert').hide();
 						var html = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>';
  							html += json.error;
							html += '</div>';
							$('#mailAlert').html(html).fadeIn();
 					}

 					if(json.success) {
 						var html = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>';
  							html += json.success;
							html += '</div>';
							$('#mailAlert').html(html).fadeIn(); 

						var tr = "<tr>";
							tr += "<td>" + json.login + "</td>";
							tr += '<td><a href="#" data-id="' + json.email_id + '" data-loading-text="Lütfen Bekleyin.." data-complete-text="Sil!" class="delete-mail btn btn-danger">Sil!</a></td>';
							tr += "</tr>";

							$('#tbody').prepend(tr);
 					}
 				});
 				return false;
 			});

			$('body').on('click', '.delete-mail', function() {
				var cfm = confirm("Bu e-posta adresini silmek istediğinizden emin misiniz?");
				if(cfm !== true) {
					return false;
				}
				var $but = $(this);
				var id = $(this).data('id');
				var url = base_url + "dashboard/delete_mail/" + site_id;
				var data = 'id=' + id;
				$but.button('loading');
				$.post(url, data, function(response) {
					$but.button('complete');
					$but.parent().parent().remove();
				});

				return false;
			});
       }
   }
});