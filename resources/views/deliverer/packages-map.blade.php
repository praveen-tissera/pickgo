
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBfcwVTCwWTisOjujfp98wN4pUxVvk6P2o&sensor=false" async defer></script>


<script>
    function makeRequest(url, callback) {
        // var request;
        // if (window.XMLHttpRequest) {
        //     request = new XMLHttpRequest(); // IE7+, Firefox, Chrome, Opera, Safari
        // } else {
        //     request = new ActiveXObject("Microsoft.XMLHTTP"); // IE6, IE5
        // }
        // request.onreadystatechange = function() {
        //     if (request.readyState == 4 && request.status == 200) {
        //         callback(request);
        //     }
        // }
        // request.open("POST", url, true);
        // request.send();





        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        url: url,
        method: 'POST',
        async: true,
        dataType: 'json',
        success: function (data) {
          console.log(data);

          var packages = data['packages'];
          callback(data);
                // packages.forEach(p => {
                //     console.log(p);
                   
                //     init_map(p);
                // });


        }
      });  

    }

    /////////////////////////////////////////////////////////////////////
    // var infowindow = new google.maps.InfoWindow();
    function displayLocation(location,infowindow) {
        
        console.log('ppppppppppppppp',location);
        var content = '<div class="infoWindow"><strong>' + location.to + '</strong>' +
            '<br/>' + location.description +
            '<br/>' + location.from + '</div>';

        if (parseInt(location.lat) == 0) {
            geocoder.geocode({
                'address': location.address
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {

                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location,
                        title: location.name
                    });

                    google.maps.event.addListener(marker, 'click', function() {
                        infowindow.setContent(content);
                        infowindow.open(map, marker);
                    });
                }
            });
        } else {
            var position = new google.maps.LatLng(parseFloat(location.lat), parseFloat(location.lng));
            var marker = new google.maps.Marker({
                map: map,
                position: position,
                title: location.to
            });

            google.maps.event.addListener(marker, 'click', function() {
                infowindow.setContent(content);
                infowindow.open(map, marker);
            });
        }
    }
    //////////////////////////////////////////////////////////////

    //<![CDATA[

    var map;

    // Ban Jelačić Square - Center of Zagreb, Croatia
    

    function init() {
        console.log('praveen');
        var infowindow = new google.maps.InfoWindow();
        var center = new google.maps.LatLng(45.812897, 15.97706);
        var geocoder = new google.maps.Geocoder();
        
        var mapOptions = {
            zoom: 13,
            center: center,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }

        map = new google.maps.Map(document.getElementById("map"), mapOptions);
        makeRequest('/deliverer/undelivered-packages', function(data) {

            // var data = JSON.parse(data.responseText);

            for (var i = 0; i < data['packages'].length; i++) {
                displayLocation(data['packages'][i],infowindow);
            }
        });

        var marker = new google.maps.Marker({
            map: map,
            position: center,
        });
    }
</script>





@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/deliverer/packagesmap.css') }}">
@endsection



@section('content')
<div class="container" onload="init();">
    <div id="map"></div>
</div>
@endsection

@section('js')
<script>
    init();
    // var map;
    //   function getData() {
    //       console.log('test');
    //     $.ajax({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //     url: "/deliverer/undelivered-packages",
    //     method: 'POST',
    //     async: true,
    //     dataType: 'json',
    //     success: function (data) {
    //       console.log(data);

    //       var packages = data['packages'];
    //             packages.forEach(p => {
    //                 console.log(p);

    //                 init_map(p);
    //             });


    //     }
    //   });  
    //   }


    //   function init_map(data) {

    //       console.log('praveen');
    //       console.log(data);
    //         var map_options = {
    //             zoom: 14,
    //             center: new google.maps.LatLng(data['lat'], data['lng'])
    //           }
    //         map = new google.maps.Map(document.getElementById("map"), map_options);
    //        marker = new google.maps.Marker({
    //             map: map,
    //             position: new google.maps.LatLng(data['lat'], data['lng'])
    //         });
    //         infowindow = new google.maps.InfoWindow({
    //             content: data['description']
    //         });
    //         google.maps.event.addListener(marker, "click", function () {
    //             infowindow.open(map, marker);
    //         });
    //         infowindow.open(map, marker);
    //     }

    /*
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
                                        <button class="btn btn-primary mx-auto getpackage" data-package-num="${l.package.num}">Get package</button>
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

        $(document).on('click','.getpackage', function(){
            var num = $(this).attr('data-package-num');
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/deliverer/deliver-package',
                method: 'POST',
                data: {"package" : num },
                success: function(data){
                    window.location.href = data['redirect'];
                }
            });
        });
    });
    */
</script>

<!-- <script src="{{ asset('js/deliverer/packagesmap.js') }}"></script>-->
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key={{ config('deliverer.google-maps-api-key') }}&callback=initMap" async defer></script> -->


@endsection