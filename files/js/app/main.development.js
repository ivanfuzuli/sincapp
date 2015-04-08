requirejs.config({
    paths: { 
        'jquery': "libraries/jquery.min", 
        'jqueryui': "plugins/jquery-ui-1.9.2.custom",
        'swfupload': "plugins/swfupload/swfupload",
        'bootstrap': 'plugins/bootstrap',
        'canTip': 'plugins/jquery.cantip',
        'canToast': 'plugins/jquery.canToast',
        'introjs': 'plugins/intro',
        'tinymce': 'plugins/tinymce/tinymce.min',
        'jquery_tinymce': 'plugins/tinymce/jquery.tinymce.min',
        'jquery.ui.widget': '../../../bower_components/blueimp-file-upload/js/vendor/jquery.ui.widget',
        'jquery.fileupload': '../../../bower_components/blueimp-file-upload/js/jquery.fileupload',
        'jquery.fileupload-process': '../../../bower_components/blueimp-file-upload/js/jquery.fileupload-process',
        'jquery.fileupload.validate': '../../../bower_components/blueimp-file-upload/js/jquery.fileupload-validate'
    }   
});

require([
    'modules/logo',
    'modules/pages',
    'modules/settings',
    'modules/social_media',
    'modules/extensions',
    'modules/paragraphs',    
    'modules/photo_cloud',
    'modules/slider_cloud',
    'modules/forms',
    'modules/maps',
    'modules/htmls',
    'modules/cover_photo',
    'modules/tour',
    'modules/language',
    'modules/menus',
    'modules/layout',
    'modules/blog',
    'modules/long_menu',
    'modules/documents',
    'extra/buy',
    'extra/csrf',
    'plugins/lightbox',
    'plugins/jquery.fitvids'
    
], 
function(logo, pages, settings, social_media, extensions, paragraphs, photo_cloud, slider_cloud, forms, maps, htmls, cover_photo, tour, language, menus, layout, blog, long_menu, documents, buy, csrf) {

        logo.init();
        pages.init();
        settings.init();
        social_media.init();
        extensions.init();
        paragraphs.init();
        photo_cloud.init();
        slider_cloud.init();
        forms.init();
        maps.init();
        htmls.init();
        cover_photo.init();
        tour.init();
        language.init();
        menus.init();
        layout.init();
        blog.init();
        long_menu.init();
        documents.init();
        buy.init();
        csrf.init();
        $('#loading').hide();
    
        $('#loading')
        .ajaxError(function(e, xhr, settings, exception) {
            if(xhr.status === 406) {
                var error = '<div id="noaccess">';
                error += '<div class="alert alert-error">';
                error += 'Güvenlik değişkeni hatalı.';
                error += '<a href="javascript:location.reload();" class="btn btn-primary">Lütfen Sayfayı Yenileyiniz.</a>'
                error += '</div>';
                error += '</div>';
                $('body').append(error);
            } else {
                $('body').append(xhr.responseText);
            }  
        });         
});
