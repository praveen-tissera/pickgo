@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/current-deliveries.css') }}">
@endsection

@section('js')
    <script src="{{ asset('js/admin/current-deliveries.js') }}"></script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('deliverer.google-maps-api-key') }}&callback=initMap" async defer></script>
@endsection

@section('content')
<div class="container">
    <h1 class="text-center">{{ __('admin/currentDeliveries.current-deliveries') }}</h1>

    <div id="map"></div>
</div>
@endsection