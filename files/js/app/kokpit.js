requirejs.config({
    paths: { 
        jquery: "libraries/jquery.kokpit",
        bootstrap: 'plugins/bootstrap.min',
        datatables: 'plugins/jquery.dataTables.min',
        tinymce: 'plugins/tinymce/tinymce.min',
        jquery_tinymce: 'plugins/tinymce/jquery.tinymce.min'
    }
});

require(['extra/kokpit', 'extra/csrf'], function(kokpit, csrf){
    kokpit.init();
    csrf.init();
});