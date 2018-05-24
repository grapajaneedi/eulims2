    var map;
    
    //-----------------------GOOGLE AUTOCOMPLETE PLACE SEARCH------------------------//
    
    function initialize() {    
        var input = document.getElementById('searchTextField');        
        var autocomplete = new google.maps.places.Autocomplete(input);
        
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
              var place = autocomplete.getPlace();
              var lat = place.geometry.location.lat();
              var lng = place.geometry.location.lng();
              var formatted_address = place.formatted_address;
              document.getElementById("customer-address").value =  formatted_address;
              document.getElementById("customer-latitude").value = lat;
              document.getElementById("customer-longitude").value = lng;

              generateGEO(lat, lng, formatted_address);
           }
        );
    }
    google.maps.event.addDomListener(window, 'load', initialize);
    
    //---------------------LOAD MAP IN MAP_CANVAS CONTAINER---------------------------//
    
    function loadMap(lat, lng) {  
        
        var deffaultCenter = new google.maps.LatLng(lat, lng)
        var mapOptions = {
           zoom: 18, 
           center: deffaultCenter ,
           panControl:false,
           zoomControl:true,
           mapTypeControl:true,
           scaleControl:false,
           streetViewControl:true,
           overviewMapControl:true,
           rotateControl:false,  
           scrollwheel: false,
           draggable: true,	
       }
       map = new google.maps.Map(document.getElementById('map'), mapOptions);
   }
   google.maps.event.addDomListener(window, 'load', loadMap(51.5072, 0.1275));
    
   //-------------------ADD LOCATION POINTER DYNAMICALLY IN MAP--------------------------//
       
   function generateGEO(lat, lng, address) {
    
        loadMap(lat, lng)
        
        var latlng = new google.maps.LatLng(lat, lng);
        var iconImg = "/images/map-marker.png";
        var marker_size = new google.maps.Size(30,40);
        var anchor_point = new google.maps.Point(20, 40);

        var iconImg = new SVGMarker({
                     map: map,
                     position: latlng,
                     icon: {
                       anchor: anchor_point,
                       size: marker_size,
                       url: iconImg
                     }
                  })

      var marker = new google.maps.Marker({ map: map, title: address, icon: iconImg });
            
      //markers.push(marker);
   }
   
   //---------------------------------------------------------------------------------------//