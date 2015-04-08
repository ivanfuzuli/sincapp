define([
    'jquery',
    'modules/long_menu',
    'i18n!nls/pages.lang',
    'jqueryui',
    'plugins/jquery.ui.nestedSortable',
    'bootstrap',
    'canTip',
    'canToast'
], function($,long_menu, lang) {
    return {
        //ilk yüklenince çalışacak fonksiyonlar
        init: function(){

                this.serilite();
                this.binder();
                this.placeholder();
                this.page_add_do_binder();

                $('#pagesBut').click(function(){
                   var $pop = $('#pages-dialog');
                   var $but = $(this);
                   var right = $but.offset().right;

                   if($pop.hasClass('hide')){
                       $but.addClass('active');
                       $pop.removeClass('hide');
                   }else{
                       $pop.addClass('hide');
                       $but.removeClass('active');
                   }

                   return false;
                });
            },

            tooltip: function(){
                $('.pageHiddenIcon').canTip({html: lang.str_page_hidden});
                $('.pageExternalIcon').canTip({html: lang.str_page_external});
                $('.pageSeoIcon').canTip({html: lang.str_page_seo});
            },

            callback: function(){
                this.serilite();
                this.binder();
            },
           //yeni sayfa ekledeki placeholder
           placeholder: function(){
                $('.placeholder-page-add').click(function(){
                    $(this).prev().focus();
                });

                $('.placeholding-page-add').find('input').focus(function(){
                    $(this).next().css({'color': '#d1d1d1'});
                }).blur(function(){
                    var $elm = $(this).next();
                    $elm.css({'color': '#999'});
                    if($(this).val().length == 0){
                        $elm.show();
                    }
                }).keypress(function(e){
                    $(this).next().hide();
                });
        },
            //sayfalar drag drop
            serilite: function(){
                      var _this = this;
                      //sıralabiliteee
                      $(".sortable").nestedSortable({
                                disableNesting: 'no-nest',
                                forcePlaceholderSize: true,
                                handle: 'div',
                                helper:	'clone',
                                items: 'li',
                                maxLevels: 3,
                                opacity: .6,
                                placeholder: 'placeholder',
                                revert: 250,
                                tabSize: 25,
                                tolerance: 'pointer',
                                toleranceElement: '> div',
                                update: function(){
                                   var serialized = $('ol.sortable').nestedSortable('serialize');
                                   var $loading = $('#loading');
                                   $loading.show();
                                   $.ajax({
                                    type: 'post',
                                    data: serialized+'&site_id='+site_id +'&page_id='  + page_id + '&prefix=' + prefix,
                                    url: base_url + 'manage/pages/sort',
                                    success: function(my_json){
                                        $loading.hide();
                                        _this._update(my_json);
                                    }
                                   })

                                }
                      })
            },
            //alanları güncelleme
            _update: function(my_json){
                     var json = $.parseJSON(my_json);

                            $.canToast(json.info);
                            $('#nav_bar').html(json.navigation);
                            $('#pagesForm').html(json.pages_content);
                            $('#page-switcher-div').html(json.pages_switcher);
                          //sırlanabilite
                          this.serilite();
                          //long menu
                          long_menu.wrap();

            },

            update_area: function(data, switcher) {
                $('#pagesForm').html(data);
                $('#page-switcher-div').html(switcher);

                //sırlanabilite
                this.serilite();
            },

            binder: function(){
                var _this = this;
                $('#editPageBut').click(function(e){
                        var $but = $(this);
                        var data = $('#pagesForm').serialize();
                        data = data + '&prefix=' + prefix;
                        //eger bilgi yoksa hata mesaji ver
                        if(data == ""){
                            $.canToast('<div class="error">'+lang.err_sel_page+'</div>');
                            return false;
                        }
                        //butonu disable et
                        $but.attr('disabled', 'disabled');
                        $.ajax({
                            type: 'post',
                            data: data+ '&page_id=' + page_id + '&site_id='+site_id,
                            url: base_url + 'manage/pages/edit',
                            success: function(data){

                                $('#modal').html(data).children(":first-child").modal();
                                _this.edit_do_binder();
                                $but.removeAttr('disabled');
                            }
                        });

                        return false;
                });

                //sayfa silme islemleri
                $('#delPageBut').click(function(){
                    var data = $('#pagesForm').serialize();
                        //eger bilgi yoksa hata mesaji ver
                    if(data == ""){
                            $.canToast('<div class="error">'+lang.err_sel_for_delete+'</div>');
                         return;
                     }

                    var $but = $(this);
                    var $delDialog = $('#deleteDialog');

                    if($delDialog.hasClass('hide')){
                        $but.attr('disabled', 'disable');
                        $delDialog.removeClass('hide');
                    }
                });
                //silme iptal
                $('#delCancelBut').click(function(){
                    $('#deleteDialog').addClass('hide');
                    $('#delPageBut').removeAttr('disabled');

                });
                //silme tamamla
                $('#delDoBut').click(function(){
                    var $but = $(this);
                    var data = $('#pagesForm').serialize();
                    var arr_data =  $('#pagesForm').serializeArray();
                        //eger bilgi yoksa hata mesaji ver
                        if(data == ""){
                            $.canToast('<div class="error">'+lang.err_sel_for_delete+'</div>');
                            return false;
                        }
                        $but.attr('disabled', 'disabled');
                        $.ajax({
                                    type: 'post',
                                    data: data + '&page_id=' + page_id + '&site_id='+site_id,
                                    url: base_url + 'manage/pages/delete_do',
                                    success: function(my_json){
                                        _this._update(my_json);
                                        //tuslar gizle
                                        $but.removeAttr('disabled');
                                        $('#deleteDialog').addClass('hide');
                                        $('#delPageBut').removeAttr('disabled');
                                        // eger bulundugu sayfayi silerse redirect et
                                        $.each( arr_data, function( i, obj ) {
                                          if (obj.value == page_id) {
                                            window.location = 'index.html';
                                          }
                                        });

                                    }
                          });
                        return false;
                });

                $('#seoPageBut').click(function(){
                    var $but = $(this);
                        var data = $('#pagesForm').serialize();
                        //eger bilgi yoksa hata mesaji ver
                        if(data == ""){
                            $.canToast('<div class="error">'+lang.err_sel_for_seo+'</div>');
                            return false;
                        }

                        $but.attr('disabled', 'disabled');
                        $.ajax({
                            type: 'post',
                            data: data+'page_id=' + page_id + '&site_id='+site_id,
                            url: base_url + 'manage/pages/seo',
                            success: function(data){
                                //kutuyu ac
                                $('#modal').html(data).children(":first-child").modal();
                                //islemleri yapan tusu bind et
                                _this.seo_do_binder();
                                $but.removeAttr('disabled');
                            }
                        });

                        return false;
                })
            },

            page_add_do_binder: function(){
                var _this = this;
                $('#pageAddForm').submit(function(){
                    var $input = $(this).find('input[name=pagename]');
                    var $but =  $(this).find('input[type=submit]');
                    var pagename = $input.val();

                    if(pagename==""){
                        $.canToast('<div class="error">'+lang.err_no_name+'</div>');
                        return false;
                    }
                        $but.attr('disabled', 'disabled');
                                $.ajax({
                                    type: 'post',
                                    data: 'pagename='+pagename+'&page_id='+page_id+'&site_id='+site_id+'&prefix=' + prefix,
                                    url: base_url + 'manage/pages/add_do',
                                    success: function(my_json){
                                        //alanlari güncelleme
                                        _this._update(my_json);
                                        $input.val('');
                                        $but.removeAttr('disabled');
                                        $input.next().show();
                                    }
                                });
                                return false;

                });
            },

            edit_do_binder: function(){
                var _this = this;
                            //dialogdaki duzenleme tusuna basinca
                            $('#pageEditForm').submit(function(){
                                var $elm = $(this);
                                var data = $elm.serialize();
                                data = data + '&prefix=' + prefix;
                                var $but = $elm.find('[type=submit]');
                                $but.button('loading');
                                $.ajax({
                                    type: 'post',
                                    data: data+'&page_id=' + page_id + '&site_id='+site_id,
                                    url: base_url + 'manage/pages/edit_do',
                                    success: function(my_json){
                                        _this._update(my_json);
                                        $elm.modal('hide');
                                    }
                                });

                                return false;
                            });

                            $('.switch-external').click(function(){
                                var $elm = $(this);
                                var $next = $elm.parent().next();
                                var $input = $elm.parents().eq(1).next().find('input');//ilerdeki

                                var defaultVal = $input[0].defaultValue;//varsayilan deger
                                var defaultExternal = $next.attr('firstVal');

                                if($next.val()=='1'){
                                    $next.val('0');
                                    $elm.animate({left: "-56px"}, 200);

                                    if(defaultExternal=="1"){//disari link varsa ona gore input doldur
                                        $input.val('');
                                    }else{
                                        $input.val(defaultVal);
                                    }

                                    $input.animate({'width':'80px'}, function(){
                                    $input.next().show();
                                    });

                                }else{
                                    $next.val('1');
                                    $elm.animate({left: "0px"}, 200);

                                    if(defaultExternal=="1"){//adres bir ise
                                        $input.val(defaultVal);
                                    }else{
                                        $input.val('http://');
                                    }

                                    $input.next().hide();
                                    $input.animate({'width':'150px'});
                                }

                            });

                            $('.switch-hidden').click(function(){
                                var $elm = $(this);
                                var $next = $elm.next();

                                if($next.val()=="1"){
                                    $next.val('0');
                                    $elm.animate({left: "-56px"}, 200);
                                }else{
                                    $next.val('1');
                                    $elm.animate({left: "0px"}, 200);
                                }
                            });
            },

            seo_do_binder: function(){
                var _this = this;
                            //onay tusu
                            $('.switch-seo').click(function(){
                                var $elm = $(this);
                                var $next = $elm.next();
                                var $input = $elm.parent().parent().next().find('input');
                                var $textarea = $elm.parent().parent().next().next().find('textarea');

                                if($next.val()=="1"){
                                    $next.val('0');
                                    $elm.animate({left: "-56px"}, 200);

                                    //inputlari gizle
                                    $input.hide();
                                    $textarea.hide();
                                }else{
                                    $next.val('1');
                                    $elm.animate({left: "0px"}, 200);

                                    //inputlari goster
                                    $input.show();
                                    $textarea.show();
                                }
                            });

                            $('#pageSeoForm').submit(function(){
                                var $elm = $(this);
                                var $but = $elm.find('[type=submit]');
                                var data = $elm.serialize();
                                data = data + '&prefix=' + prefix;
                                $but.button('loading');
                                $.ajax({
                                    type: 'post',
                                    data: data+'&page_id='+page_id+'&site_id='+site_id,
                                    url: base_url + 'manage/pages/seo_do',
                                    success: function(my_json){
                                        _this._update(my_json);
                                        $elm.modal('hide');
                                    }
                                });
                                return false;
                               });
            }
    };
});
