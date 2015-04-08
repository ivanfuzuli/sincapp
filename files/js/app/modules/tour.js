define(['jquery', 'plugins/intro'], function($, introJs){
   return{
       init: function(){
        var _this = this;
        return false;
        if(tour == "1") {
          this.start();
        }
        $('#helpBut').click(function() {
           _this.start();
        })
       },

       start: function() {
          $('#top_hr').css('marginTop', '40px');
          $('#fixed').css({position: 'absolute', padding: '10px'});
          $('.dragMe').css({backgroundColor :'#000'});
          var intro = introJs().onexit(this.close).oncomplete(this.close);
          intro.setOptions({
            exitOnEsc: false,
            exitOnOverlayClick: false,
            steps: [
              { 
                intro: "Sincapp'a hoşgeldiniz. Bu kısa turu ile daha fazla bilgiye sahip olacaksınız."
              },
              {
                element:'#paragraph_but' ,
                intro: "Yazı alanı oluşturmak için bu eklentiyi sürükleyip bırakın."
              },
              {
                element: '#photo_but',
                intro: "Fotoğraf albümü oluşturmak için bu eklentiyi sürükleyip bırakın.",
              },
              {
                element: '#slider_but',
                intro: 'Dönen resimler oluşturmak için bu eklentiyi sürükleyip bırakın.',
              },
              {
                element: '#form_but',
                intro: "İletişim formu oluşturmak için bu eklentiyi sürükleyip bırakın.",
              },
              {
                element: '#maps_but',
                intro: "Harita oluşturmak için bu eklentiyi sürükleyip bırakın.",
              },
              {
                element: '#html_but',
                intro: 'Html&Javascript kodları oluşturmak için bu eklentiyi sürükleyip bırakın.'
              },
              {
                element: '#logo',
                intro: 'Logo yazısını değiştirmek için tıklayın. İsterseniz fotoğraf da ekleyebilirsiniz.',
              },
              {
                element: '#pagesBut', 
                intro: 'Yeni sayfa yaratmak için bu tuşu kullanın. Varolan sayfaların sıralamasını sürükleyip bırakarak değiştirebilirsiniz',
                position: 'left'
              },
              {
                element: '#extraBut',
                intro: 'Tema değiştirmek veya çıkış yapmak için bu tuşu kullanın.',
                position: 'left'
              }
            ]
          });
          intro.start();        
       },
       close: function() {
          $('#top_hr').css('marginTop', '30px');
          $('#fixed').css({position: 'fixed'});
          $('#fixed').animate({padding: '0px'});
          $('.dragMe').css({backgroundColor :'transparent'});        
          $.post(base_url+'manage/settings/tourComplete', 'site_id='+site_id,  function(){   
           });
       }
   }
});