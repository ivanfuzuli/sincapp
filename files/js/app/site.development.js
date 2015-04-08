requirejs.config({
    paths: { 
        jquery: "libraries/jquery.min"
    }
});

require(['modules/long_menu', 'common/maps', 'common/forms', 'common/slider_cloud', 'common/bottom', 'plugins/lightbox'], function(long_menu, maps, forms, slider, bottom){
    long_menu.init();
    maps.init();
    forms.init();
    slider.init();
    bottom.init();
});