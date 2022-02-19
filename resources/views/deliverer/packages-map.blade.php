@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/deliverer/packagesmap.css') }}">
@endsection



@section('content')
<div class="container">
    <div id="map"></div>
</div>
@endsection

@section('js')
<script>
var map;
  function getData() {
      console.log('test');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    url: "/deliverer/undelivered-packages",
    method: 'POST',
    async: true,
    dataType: 'json',
    success: function (data) {
      console.log(data);

      var packages = data['packages'];
            packages.forEach(p => {
                console.log(p);
                // add the locations
                // locations.push({
                //     loc : {lat: parseFloat(p.lat), lng: parseFloat(p.lng)},
                //     package : p,
                // });
                init_map(p);
            });
      //load map
      
    }
  });  
  }


  function init_map(data) {

      console.log('praveen');
      console.log(data);
        var map_options = {
            zoom: 14,
            center: new google.maps.LatLng(data['lat'], data['lng'])
          }
        map = new google.maps.Map(document.getElementById("map"), map_options);
       marker = new google.maps.Marker({
            map: map,
            position: new google.maps.LatLng(data['lat'], data['lng'])
        });
        infowindow = new google.maps.InfoWindow({
            content: data['description']
        });
        google.maps.event.addListener(marker, "click", function () {
            infowindow.open(map, marker);
        });
        infowindow.open(map, marker);
    }


</script>

    <!-- <script src="{{ asset('js/deliverer/packagesmap.js') }}"></script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script> -->
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key={{ config('deliverer.google-maps-api-key') }}&callback=initMap" async defer></script> -->

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBfcwVTCwWTisOjujfp98wN4pUxVvk6P2o&callback=getData" async defer></script> 
@endsection