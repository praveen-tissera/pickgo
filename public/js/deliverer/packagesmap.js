
    var map;
    var markers;
    var locations = [];
    var infowindow;

    //get undelivered packages to dispaly in the map
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/deliverer/undelivered-packages',
        method: 'POST',
        //data: {"package" :  package },
        success: function(data){
            var packages = data['packages'];
            packages.forEach(p => {
                // add the locations
                locations.push({
                    loc : {lat: parseFloat(p.lat), lng: parseFloat(p.lng)},
                    package : p,
                });
            });

            infowindow = locations.map(function(l, i){
                return new google.maps.InfoWindow({
                    content: `<div class="container">
                                <h3 class="text-center">Deliver this package</h3>
                                <div class="row">
                                    <h4 class="col-12 text-center">Weight : ${l.package.weight}</h4>
                                    <h4 class="col-12 text-center">Delivers Date : ${l.package.delivers_date}</h4>
                                </div>
                                <div class="row">
                                    <button class="btn btn-primary mx-auto getpackage" data-package-num="${l.package.id}">Get package</button>
                                </div>
                                </div>
                            </div>`,
                    num: l.package.num
                });
            });

            markers = locations.map(function(location, i) {
                return new google.maps.Marker({
                    position: location.loc,
                    label: location.package.name,
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

    $(document).on('click','.getpackage', function(){
        var num = $(this).attr('data-package-num');
        console.log('praveen',num);
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/deliverer/deliver-package',
            method: 'POST',
            data: {"package" : num },
            dataType: 'json',
            success: function(){
                alert('Package Updated Successfully');
                // window.location.href = data['redirect'];
            },
            error: function(jqXhr, textStatus, errorMessage){
                alert('Package Updated Successfully');
             }
        });
    });

