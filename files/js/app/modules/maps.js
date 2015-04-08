define(['jquery', 'canToast'], function($) {
    var loaded = false;         
    var mapArr = new Array();
    var markerArr = new Array();
       
   return {
       firstRun: function(){
           if(loaded == true){
             this.loadMap();
             this.mapPlaceholder();      
           }else{
               this.init();
           }
       },
       
       init: function(){
        var _this = this;
        if($('.maps').size() > 0){//eger hali hazirda harita varsa yükle yoksa bekle
            require(['https://www.google.com/jsapi'] ,function(){
                        google.load("maps", "3", {
                            callback: function(){
                                 _this.loadMap();
                                 _this.mapPlaceholder();
                                 loaded = true;
                            },
                            other_params: "key=AIzaSyC4_GQiImJfsCCrfVdeiKRFG4lLXzxSfKU&sensor=false&libraries=places"
                        });
                    });

            this.binder();
        }
       },
       
       binder: function(){
           var _this = this;
           $('body').on('click', '.mapSearchBut', function(){
               var $input = $(this).prev();
               var address = $input.val();
               var mapId = $input.attr('data-map-id');
               
               mapId = 'map_'+mapId;               
               _this._getAddress(address, mapId);
               
               return false;
           });

           $('body').on('click', '.mapSaveBut', function(){
               var $elm = $(this);
               var $map = $elm.parents().eq(2).next();
               
               var map_title = '';
               var map_id = $elm.attr('data-map-id');               
               var latitude = $map.attr('data-latitude');
               var longitude = $map.attr('data-longitude');
               var zoom = $map.attr('data-zoom');
               var data = 'site_id='+site_id+'&map_id='+map_id+'&map_title='+map_title+'&latitude='+latitude+'&longitude='+longitude+'&zoom='+zoom;
                
               $elm.attr('disabled', 'disabled');
                $.ajax({
                    type: 'post',
                    data: data,
                    url: base_url + 'manage/maps/save',
                    success: function(data){  
                        $.canToast(data);
                        $elm.removeAttr('disabled');
                        $elm.hide();
                    }});
           })         
       },
        _showSaveBut: function(map_id){
            map_id = map_id.split("_");
            map_id = map_id[1];
            $('#mapSave_'+map_id).show();
        },
       loadMap: function(){
       var _this = this;
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
              draggable:true
          });  
         
         var $input = elem.prev().find('[name=adressbar]')[0];
         var autocomplete = new google.maps.places.Autocomplete($input);
        autocomplete.bindTo('bounds', mapArr[map_id]);

        google.maps.event.addListener(autocomplete, 'place_changed', function() {
          var place = autocomplete.getPlace();
          
          if(place.geometry == undefined){//enter bug fix
               _this._getAddress($input.value, map_id);              
               return false;
          }
          
          if (place.geometry.viewport) {
            mapArr[map_id].fitBounds(place.geometry.viewport);
          } else {
            mapArr[map_id].setCenter(place.geometry.location);
            mapArr[map_id].setZoom(17);  // Why 17? Because it looks good.
          }

          markerArr[map_id].setPosition(place.geometry.location);
              elem.attr('data-latitude', place.geometry.location.lat());
              elem.attr('data-longitude', place.geometry.location.lng());
              elem.attr('data-zoom', '17');
              _this._showSaveBut(map_id);
        /*
          var address = '';
          if (place.address_components) {
            address = [(place.address_components[0] &&
                        place.address_components[0].short_name || ''),
                       (place.address_components[1] &&
                        place.address_components[1].short_name || ''),
                       (place.address_components[2] &&
                        place.address_components[2].short_name || '')
                      ].join(' ');
          }

          infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
          infowindow.open(map, marker);
          */
        });         
         //info window
       /*  var contentString = elem.prev().find('[name=mapTitle]').val();
         var infowindow = new google.maps.InfoWindow({
            content: contentString
        });
           
        google.maps.event.addListener(markerArr[map_id], 'click', function() {
            infowindow.open(mapArr[map_id],markerArr[map_id]);
        });
        */
        //admin fonksiyon
        google.maps.event.addListener( markerArr[map_id], 'dragend', function(event){    
              elem.attr('data-latitude', event.latLng.lat());
              elem.attr('data-longitude', event.latLng.lng());
              _this._showSaveBut(map_id);
            
        });

        google.maps.event.addListener(mapArr[map_id], 'zoom_changed', function() {
            var zoomLevel = mapArr[map_id].getZoom();
            elem.attr('data-zoom', zoomLevel);
            _this._showSaveBut(map_id);
        });
        })
       
       },

    _getAddress: function(address, map_id){
    var _this = this;
    //eger daha once marker varsa sil
    if(markerArr[map_id] != null){
        markerArr[map_id].setMap(null);
    }
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        mapArr[map_id].setCenter(results[0].geometry.location);
      //  $('#loc').val(results[0].geometry.location);
      $('#'+map_id).attr('data-latitude', results[0].geometry.location.lat())
                   .attr('data-longitude', results[0].geometry.location.lng());
                       
          markerArr[map_id] = new google.maps.Marker({
            map: mapArr[map_id], 
            draggable:true,
	    animation: google.maps.Animation.DROP,
            position: results[0].geometry.location
        });

        mapArr[map_id].setZoom(8);		
        _this._showSaveBut(map_id);

              } else {
                alert("Geocode was not successful for the following reason: " + status);
              }
      });         
     },
     
       mapPlaceholder: function(){
           var support = this.hasPlaceholderSupport();
           //desteklemiyosa degerleri iceri at
           if(support == false){
               $('.mapSettings').find('[placeholder]').each(function(){
                    var input = $(this);
                    input.val(input.attr('placeholder'));
               });
           }
           $('.mapSettings').on("focus", '[placeholder]', function(){
               
                 var input = $(this);
                 input.css('color','#000');

                 if(support == false && input.val() == input.attr('placeholder')){
                     input.val('');
                 }
                         
           });

           $('.mapSettings').on("blur", '[placeholder]', function(){
                 var input = $(this);

                 if(input.val() == ""){
                     input.css('color','#666');
                 }

                 if(support == false && input.val() == ""){
                     input.val(input.attr('placeholder'));
                 }
             });
    },
    //browser'a bak bakiim destekliyo muymus'
    hasPlaceholderSupport: function() {
    var input = document.createElement('input');
        return ('placeholder' in input);
    }     
       
   }
});
