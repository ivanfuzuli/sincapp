define(['jquery'], function($) {
             
    var mapArr = new Array();
    var markerArr = new Array();
       
   return {
       init: function(){
        var _this = this;
        if($('.maps').size() > 0){//eger hali hazirda harita varsa yükle yoksa bekle
            require(['http://www.google.com/jsapi'] ,function(){
                        google.load("maps", "3", {
                            callback: function(){
                                 _this.loadMap();
                            },
                            other_params: "key=AIzaSyC4_GQiImJfsCCrfVdeiKRFG4lLXzxSfKU&sensor=false"
                        });
                    });
        }
       },

       loadMap: function(){
       var myOptions;
            
        $('.maps').each(function(){
            var elem = $(this);
            var map_id = elem.attr('id');

            var latitude = elem.attr('data-latitude');
            var longitude = elem.attr('data-longitude');
            var zoom = parseInt(elem.attr('data-zoom'));
           
            var myLatlng = new google.maps.LatLng(latitude, longitude);
        myOptions = {
          center: myLatlng,
          zoom: zoom,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };             
            mapArr[map_id] = new google.maps.Map(document.getElementById(map_id),
            myOptions); 
            
         markerArr[map_id] = new google.maps.Marker({
              position: myLatlng,
              map: mapArr[map_id],
              draggable:false
          });  
         
         /*
         var contentString = elem.prev().find('[name=mapTitle]').val();
         var infowindow = new google.maps.InfoWindow({
            content: contentString
        });
           
        google.maps.event.addListener(markerArr[map_id], 'click', function() {
            infowindow.open(mapArr[map_id],markerArr[map_id]);
        });
        */
        });
       
       }         
   }
});
