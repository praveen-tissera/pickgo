$(document).ready(function(){
    var map;
    var markers;
    var locations = [];
    var infowindow;

    //get undelivered packages to dispaly in the map
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/current-deliveries',
        method: 'POST',
        //data: {"package" :  package },
        success: function(data){
            var packages = data['data']['packages'];
            var deliverers = data['data']['deliverers'];

            packages.forEach(p => {
                // add the locations
                let d = deliverers.filter(d => p.deliverer == d.id);
                locations.push({
                    loc : {lat: parseFloat(p.lat), lng: parseFloat(p.lng)},
                    deliverer: d,
                    package : p,
                });
            });

            infowindow = locations.map(function(l, i){
                return new google.maps.InfoWindow({
                    content: `<div class="container">
                                <div class="row">
                                    <div class="container">
                                        <h4 class="p-1">Deliverer : ${l.deliverer[0].firstname} ${l.deliverer[0].lastname}</h4>
                                        <h5 class="p-1">Phone : ${l.deliverer[0].phone}</h5>
                                        <h5 class="p-1">Package : ${l.package.num}</h5>
                                        <h5 class="p-1">CIN : ${l.deliverer[0].cin}</h5>
                                    </div>
                                </div>
                            </div>`,
                    num: l.package.num
                });
            });

            markers = locations.map(function(location, i) {
                return new google.maps.Marker({
                    position: location.loc,
                    label: location.package.num,
                    map: map,
                    num: location.package.num,
                });
            });

            // markers.addListener('click', function(){
            //     infowindow.open(map, markers);
            // });

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

            // console.log(markers);
            // console.log(typeof markers);

            // Add a marker clusterer to manage the markers.
            window.markerCluster = new MarkerClusterer(map, markers,
                {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'}
            );
            // packages.forEach(p => {
                
            // });
        }
    });


    window.initMap = function () {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 33.9271265, lng: -7.0757109},
            zoom: 8
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
});
