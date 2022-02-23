@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/deliverer/packageinfo.css') }}">
@endsection

@section('js')
    <script src="{{ asset('js/deliverer/packageinfo.js') }}"></script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBfcwVTCwWTisOjujfp98wN4pUxVvk6P2o&callback=initMap" async defer></script>
@endsection

@section('content')
<div class="container">
    <h1 class="text-center">{{ __('deliverer/package-info.package-info') }}</h1>



    <ul class="nav nav-tabs" id="packages-tab" role="tablist">
        @foreach($package as $key => $p)
            <li class="nav-item">
                <a class="nav-link {{ $key == 0 ? 'active' : '' }}" id="package-{{ $p->id }}-tab" data-toggle="tab" href="#package-{{ $p->id }}" role="tab" aria-controls="package-{{ $p->id }}" aria-selected="true">{{ __('deliverer/package-info.package') . ' ' . $p->num }}</a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content" id="myTabContent">
        @foreach($package as $key => $p)
            <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="package-{{ $p->id }}" role="tabpanel" aria-labelledby="package-{{ $p->id }}-tab">
                <div class="jumbotron">
                    <div class="container">
                        <h1 class="display-4 package-num" data-package-num="{{ $p->num }}">{{ __('deliverer/package-info.ref') }} : {{ $p->num }}</h1>
                        <hr class="my-4">
                        <p class="package-weight" data-package-weight="{{ $p->weight }}">
                            <span class="font-weight-bold">{{ __('deliverer/package-info.weight') }}</span> : {{ $p->weight }}
                        </p>
                        <p class="package-delivers-date" data-package-delivers-date="{{ $p->delivers_date }}">
                            <span class="font-weight-bold">{{ __('deliverer/package-info.delivers-date') }}</span> : {{ $p->delivers_date->diffForHumans() }}
                        </p>
                        <p class="package-from" data-package-from="{{ $p->from }}">
                            <span class="font-weight-bold">{{ __('deliverer/package-info.from') }}</span> : {{ $p->from }}
                        </p>
                        <p class="package-to" data-package-to="{{ $p->to }}">
                            <span class="font-weight-bold">{{ __('deliverer/package-info.to') }}</span> : {{ $p->to }}
                        </p>
                        <p class="package-description">
                            <span class="font-weight-bold">{{ __('deliverer/package-info.desc') }}</span> : {!! $p->description !!}
                        </p>
                        <hr class="my-4">
                        <button class="btn btn-primary btn-lg mark-package-delivered">{{ __('deliverer/package-info.mark-delivered') }}</button>
            
                        <span class="d-none package-lat" data-package-lat="{{ $p->lat }}"></span>
                        <span class="d-none package-lng" data-package-lng="{{ $p->lng }}"></span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>







    

    <div id="map"></div>
</div>
@endsection