define([
    'jquery', 
    'helpers/toolbar',
    'jquery_tinymce'
], function($, toolbar) {
	return {
	firstRun: function(id) {
		var $elm = $('#ext_' + id).find('.blog_cloud');
		cloud_id = $elm.data('blog-cloud-id');
		this.open_edit_blog_form(cloud_id);
	},
	init: function() {
		var _this = this;
		this.bind_delete();
		this.bind_edit();
		this.bind_hover();
		$('.blogEditBut').canTip({html: 'Blog ayarlarını güncellemek için tıklayın.'});
		$('body').on('click', '.blogEditBut', function() {
			var $elm = $(this);
			var $loading = $('#loading');
			var cloud_id = $elm.parent().next().children(":first").data('blog-cloud-id');
			_this.open_edit_blog_form(cloud_id);
			return false;
		});
		$('body').on('click', '.add-post', function() {
			var $elm = $(this).parent().parent();
			_this.open_form($elm);
			return false;
		});	
	},

	add_blog: function() {
		var name = $('#blog-name').val();
		var $btn = $('#btn-add-blog');
		if(name == "") {
			$.canToast('<div class="error">Lütfen blog için bir isim girin.</div>');
			return false;
		}
		$btn.attr('disabled', 'disabled');
		$.post(base_url + 'manage/blog/add_blog', {site_id: site_id, name: name, prefix: prefix}, function(response){
			$('#blog-list').html(response);
			$.canToast('<div class="success">Yeni blog başarılı bir şekilde eklendi');
			$('#blog-name').val('');
			$btn.removeAttr('disabled');
		});
	},

	bind_add_blog: function() {
		var _this = this;
		$('#btn-add-blog').click(function() {
			_this.add_blog();
			return false;
		});
		$('#blog-name').keypress(function(event) {
		   if (event.keyCode == 10 || event.keyCode == 13) {
		        _this.add_blog();
		        event.preventDefault();
		    }
		});
	},

	bind_remove_blog: function() {
		$('#btn-delete-blog').click(function() {
			var cloud_id = $('#editCloudForm').find('[name=blog_cloud_id]').val();
			var cloud_blog_id = $('#blogCloud_' + cloud_id).data('blog-id');		
			var blog_id = $('#blog-list').find('select').val();
			if(cloud_blog_id == blog_id) {
				$.canToast('<div class="error">İçinde bulunduğunuz blog\'u silemezsiniz.</div>');
				return false;
			}

			var result = confirm("Bu blogu silerseniz bağlı olan tüm yazılar da silinecektir. Silmek istiyor musunuz?");
			if(result == false) {
				return false;
			}
			
			$.post(base_url + 'manage/blog/remove_blog', {site_id: site_id, blog_id: blog_id, prefix: prefix}, function(response){
				var json = $.parseJSON(response);
				if(json.statu == 'success') {
					$('#blog-list').html(json.dropdown);
					$.canToast('<div class="success">Blog başarılı bir şekilde silindi.</div>');
				} else {
					$.canToast(json.error_text);
				}
			});
			return false;
		});
	},

	open_edit_blog_form: function(cloud_id) {
		var $loading = $('#loading');
		var _this = this;
			$loading.show();
            $.post(base_url+"manage/blog/edit_cloud", {site_id: site_id, blog_cloud_id: cloud_id, prefix: prefix}, function(data){
               $loading.hide();
               $('#modal').html(data).children(':first-child').modal();
               _this.bind_edit_cloud();
               _this.bind_remove_blog();
               _this.bind_add_blog();
            });		
	},

	open_form: function($elm) {
			var _this = this;
			var $loading = $('#loading');
			var cloud_id = $elm.data('blog-cloud-id');
			var blog_id = $elm.data('blog-id');
			$loading.show();
			$.post(base_url + 'manage/blog/add', {site_id: site_id, cloud_id: cloud_id, blog_id: blog_id}, function(response) {
				$loading.hide();
				_this.append_blog(response);
				_this.bind_tinymce();
				_this.bind_post(cloud_id);
			});

			return false;
	},

	bind_edit_cloud: function() {
        $('#editCloudForm').submit(function(){
            var $elm = $(this);
            var $but = $elm.find('[type=submit]');
            var cloud_id = $elm.find('[name=blog_cloud_id]').val();
            var blog_id = $elm.find('[name=blog_id]').val();
            var data = $elm.serialize();
             $.post(base_url+"manage/blog/update_cloud", data, function(response){
                   $.canToast('<div class="success"> Blog ayarları başarılı bir şekilde güncellenmiştir.</div>');  
                   $('#blogCloud_' + cloud_id).html(response);
                   $('#blogCloud_' + cloud_id).data('blog-id', blog_id);
                   $elm.modal('hide'); 
             });               
            return false;
        });
	},

	bind_hover: function() {
		$('body').on('mouseenter', '.post', function() {
			$(this).find('.btn-blog-group').fadeIn();
		});
		$('body').on('mouseleave', '.post', function() {
			$(this).find('.btn-blog-group').fadeOut();
		});
	},

	bind_edit_submit: function(cloud_id) {
		$('#add-post').submit(function() {
			var $loading = $('#loading');
			var data = $(this).serialize();
			$('#loading').show();
			$('#blog-submit').attr('disabled', 'disabled');
			$.post(base_url + 'manage/blog/update', data, function(response) {
				$('#loading').hide();
				$('#blog-submit').removeAttr('disabled');
			    $.canToast('<div class="success">Blog yazınız başarılı bir şekilde güncellendi.</div>');
				$('#blogCloud_' + cloud_id).html(response);
			});
			return false;
		});
	},

	bind_post: function(cloud_id) {
		$('#add-post').submit(function() {
			var $loading = $('#loading');
			var data = $(this).serialize();
			$('#loading').show();
			$('#blog-submit').attr('disabled', 'disabled');
			$.post(base_url + 'manage/blog/post', data, function(response) {
				$('#loading').hide();
				$('#blog-submit').removeAttr('disabled');
				$('#post-title').val('');
				$('#post-content').val('');
			    $.canToast('<div class="success">Yeni blog yazınız başarılı bir şekilde eklendi.</div>');
				$('#blogCloud_' + cloud_id).html(response);
			});
			return false;
		});
	},

	bind_delete: function() {
		var _this = this;
		$('body').on('click', '.delete-post', function() {
	 		var result = confirm("Bu blog yazısını gerçekten silmek istiyor musunuz?");
			if(result == false) {
				return false;
			}			
			var $elm = $(this).parent().parent().parent();
			var $loading = $('#loading');
			var cloud_id = $elm.data('blog-cloud-id');
			var blog_id = $elm.data('blog-id');
			var post_id = $(this).data('post-id');
			$loading.show();
			$.post(base_url + 'manage/blog/delete', {site_id: site_id, blog_cloud_id: cloud_id, blog_id: blog_id, post_id: post_id}, function(response) {
				$loading.hide();
				$.canToast('<div class="success">Seçtiğiniz yazı başarılı bir şekilde silindi.</div>');
				$('#blogCloud_' + cloud_id).html(response);
			});

			return false;
		});
	},

	bind_edit: function() {
		var _this = this;
		$('body').on('click', '.edit-post', function() {
			var $elm = $(this).parent().parent().parent();
			var $loading = $('#loading');
			var cloud_id = $elm.data('blog-cloud-id');
			var blog_id = $elm.data('blog-id');
			var post_id = $(this).data('post-id');
			$loading.show();
			$.post(base_url + 'manage/blog/edit', {site_id: site_id, cloud_id: cloud_id, blog_id: blog_id, post_id: post_id}, function(response) {
				$loading.hide();
				_this.append_blog(response);
			    _this.bind_edit_submit(cloud_id);
				_this.bind_tinymce();
			});

			return false;
		});	
	},

	append_blog: function(response) {
		var _this = this;
		var width = $( document ).width();
		$('body').append('<div id="blog-container" style="left:'+width+'px">'+response+'</div>');
		$('#blog-container').animate({'left': '0px'}, 500);
		$('#but-editor').removeClass('active');
		$('#but-blog').show();
		$('#but-editor, #cancel-post').click(function() {
			_this.close_editor();
			return false;
		});
	},

	close_editor: function() {
		var width = $( document ).width();
		$('#blog-container').animate({'left': width+'px'}, 500, function() {
			$('#blog-container').remove();
		});
		$('#but-editor').unbind('click');
		$('#but-editor').addClass('active');
		$('#but-blog').hide();
		$("#post-content").tinymce().remove();
		return false;		
	},
      bind_tinymce: function() {
      	  var _this = this;
          $('#post-content').tinymce({
                  language: 'tr_TR',
                  height: 200,
                  relative_urls : false,
                  remove_script_host : false,
                  convert_urls : true,
                  theme_advanced_resizing : true,
                  plugins: [
                      "fullscreen wordcount hr textcolor autolink lists link image print anchor",
                      "searchreplace visualblocks code",
                      "media table contextmenu paste"
                  ],
                  toolbar: "fullscreen fontsizeselect styleselect | bullist, numlist | link unlink imagebutton | bold underline italic | alignleft aligncenter alignright alignjustify |  outdent indent | forecolor read_more",
                  setup: function(ed) {
                     ed.addButton('imagebutton', {
                          title : 'Fotograf Ekle',
                          image : base_url + 'files/js/app/plugins/tinymce/img/photo-icon.png',
                          onclick : function() {
                              // Add you own code to execute something on click
                              toolbar.blog_photo_callback();
                          }
                      });
                     ed.addButton('read_more', {
                          title : 'Devamını Oku Ekle',
                          image : base_url + 'files/js/app/plugins/tinymce/img/more-icon.png',
                          onclick : function() {
                          	  var more = '<img class="read_more" src="'+base_url + 'files/js/app/plugins/tinymce/img/read-more.png" data-mce-resize="false" data-mce-placeholder="1"/>';
                              tinyMCE.execCommand('mceInsertContent', false, more);
                          }
                      });
                      ed.on('ObjectResized', function(e) {
                      	var target = $(e.target).prop("tagName");
                      	if(target != 'IMG'){
                      		return false;
                      	};

                        var $element = $(e.target);
                        var blog_pic_id = $element.attr('data-blog_pic_id');
                        var width = e.width;
                        var height = e.height;
                        var src = $element.attr('src');
                            $.post(base_url+"manage/blog/resize", {site_id: site_id, blog_pic_id: blog_pic_id, width: width, height: height}, function(data){
                               $.canToast(data);
                               //yeniden boyutlandirilmis halini al
                               var newSrc;
                               var stamp = new Date().getTime();
                               var srdata = src.split('?');//fazla soru isareti olmasin
                               if(srdata[0]){//eger soru isareti varsa
                                   newSrc = srdata[0]+'?'+stamp;
                               }else{
                                   newSrc = src+'?'+stamp;
                               }
                               $element.attr('src', newSrc);
                            });
                      });

                  },

                 });
      }
     }
});