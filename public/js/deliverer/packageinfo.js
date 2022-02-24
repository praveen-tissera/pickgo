
    var map;
    var markers;
    var locations = [];

    //get the deliverer assigned packages
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/deliverer/deliverer-assigned-packages',
        method: 'POST',
        success: function(data){
            var packages = data['packages'];
            packages.forEach(p => {
                // add the locations
                locations.push({
                    loc : {lat: parseFloat(p.lat), lng: parseFloat(p.lng)},
                    ref : p.num,
                });
            });

            infowindow = locations.map(function(l, i){
                return new google.maps.InfoWindow({
                    content: `<div class="container">
                                <h3 class="text-center">Deliver this package</h3>
                                <div class="row">
                                    <h4 class="col-12 text-center">Reference : ${l.ref}</h4>
                                </div>
                            </div>`,
                    num: l.ref
                });
            });

            markers = locations.map(function(location, i) {
                return new google.maps.Marker({
                    position: location.loc,
                    label: location.ref,
                    map: map,
                    num: location.ref,
                });
            });

            markers.map(m => {
                m.addListener('click', function(){
                    infowindow.map(i => {
                        if(i.num === m.num){
                            i.open(map, m);
                        }else{
                            i.close();
                        }
                    });
                });
            });

            // Add a marker clusterer to manage the markers.
            window.markerCluster = new MarkerClusterer(map, markers,
                {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'}
            );
        }
    });

    window.initMap = function () {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 33.9271265, lng: -7.0757109},
            zoom: 1
        });
        
        //set the markers
        markers = locations.map(function(location, i) {
            return new google.maps.Marker({
                position: location,
                label: "abc"+i % 23,
                map: map,
            });
        });

        // Add a marker clusterer to manage the markers.
        window.markerCluster = new MarkerClusterer(map, markers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'}
        );
    }

    $('.mark-package-delivered').click(function(){
                var package = $('.package-num').attr('data-package-num');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/deliverer/mark-delivered',
                    method: 'POST',
                    data: {"package" : package },
                    success: function(data){
                        window.location.href = data['redirect'];
                    }
                });
            });

// legacy code for when the deliverer could deliver one package at a time
// $(document).ready(function(){
//     var map;
//     var marker;
//     //get the location
//     var location = {
//         lat : parseFloat($('.package-lat').attr('data-package-lat')),
//         lng : parseFloat($('.package-lng').attr('data-package-lng')),
//     };

//     window.initMap = function () {
//         map = new google.maps.Map(document.getElementById('map'), {
//             center: {lat: 33.9271265, lng: -7.0757109},
//             zoom: 8
//         });

//         marker = new google.maps.Marker({
//             position: location,
//             map: map,
//         });

//         map.setCenter(location);

//         // Add a marker clusterer to manage the markers.
//         window.markerCluster = new MarkerClusterer(map, markers,
//             {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'}
//         );
//     }

//     $('.mark-package-delivered').click(function(){
//         var package = $('.package-num').attr('data-package-num');
//         $.ajax({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             },
//             url: '/deliverer/mark-delivered',
//             method: 'POST',
//             data: {"package" : package },
//             success: function(data){
//                 window.location.href = data['redirect'];
//             }
//         });
//     });
// });