requirejs.config({
    paths: { 
        jquery: "libraries/jquery.min",
        bootstrap: 'plugins/bootstrap',
        colorbox: 'plugins/jquery.colorbox-min',
        card: 'plugins/card'
    }
});

require(['extra/home', 'extra/footer', 'extra/dashboard', 'extra/forgot', 'extra/theme', 'extra/buy', 'extra/mail', 'extra/stats', 'extra/csrf'], function(home, footer, dashboard, forgot, theme, buy, mail, stats, csrf){
    home.init();
    footer.init();
    dashboard.init();
    forgot.init();
    theme.init();
    buy.init();
    mail.init();
    stats.init();
    csrf.init();
});