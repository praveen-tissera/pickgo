@extends('layouts.app')

@section('content')
<h1 class="text-center">{{ isset($package) ? __('admin/managePackage.edit') : __('admin/managePackage.add') }}</h1>

{{-- add/edit form --}}
<form action="{{ isset($package) ? route('edit-package', ['package' => $package->id]) : route('add-package') }}" method="post" class="col-md-6 mx-auto">
    @csrf

    {{-- num --}}
    <div class="form-group">
        <input type="text" name="num" id="num" class="form-control" placeholder="{{ __('admin/managePackage.num') }} ({{ __('admin/managePackage.opt') }})" value="{{ isset($package->num) ? $package->num : '' }}">

        {{-- display the erors --}}
        @error('num')
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
        @enderror
    </div>

    {{-- weight --}}
    <div class="form-group">
        <input type="number" name="weight" id="weight" class="form-control" placeholder="{{ __('admin/managePackage.weight') }}" value="{{ isset($package->weight) ? $package->weight : '' }}">

        {{-- display the erors --}}
        @error('weight')
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
        @enderror
    </div>

    {{-- delivery date --}}
    <div class="form-group">
        <label for="ddate">{{ __('admin/managePackage.ddate') }}</label>
        <input type="date" name="ddate" id="ddate" class="form-control" value="{{ isset($package->delivers_date) ? \Carbon\Carbon::parse($package->delivers_date)->format('Y-m-d') : '' }}">
        
        {{-- display the erors --}}
        @error('ddate')
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
        @enderror
    </div>

    {{-- from --}}
    <div class="form-group">
        <input type="text" name="from" id="from" class="form-control" placeholder="{{ __('admin/managePackage.from') }}" value="{{ isset($package->from) ? $package->from : '' }}">

        {{-- display the erors --}}
        @error('from')
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
        @enderror
    </div>

    {{-- to --}}
    <div class="form-group">
        <input type="text" name="to" id="to" class="form-control" placeholder="{{ __('admin/managePackage.to') }}" value="{{ isset($package->to) ? $package->to : '' }}">

        {{-- display the erors --}}
        @error('to')
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
        @enderror
    </div>


    {{-- cordinates --}}
    <div class="row">
        <div class="form-group col-md-5">
            <input type="text" name="lat" id="lat" class="form-control" placeholder="{{ __('admin/managePackage.lat') }}" value="{{ isset($package->lat) ? $package->lat : '' }}">

            {{-- display the erors --}}
            @error('lat')
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
            @enderror
        </div>

        <div class="form-group col-md-5">
            <input type="text" name="lng" id="lng" class="form-control" placeholder="{{ __('admin/managePackage.lng') }}" value="{{ isset($package->lng) ? $package->lng : '' }}">

            {{-- display the erors --}}
            @error('lng')
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
            @enderror
        </div>
    </div>

    {{-- description --}}
    <div class="form-group">
        <textarea name="desc" id="desc" cols="30" rows="10" class="form-control" placeholder="{{ __('admin/managePackage.desc') }}">{{ isset($package->description) ? $package->description : '' }}</textarea>
        
        {{-- display the erors --}}
        @error('desc')
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
        @enderror
    </div>

    {{-- submit --}}
    <input type="submit" value="{{ isset($package) ? __('admin/managePackage.edit') : __('admin/managePackage.add') }}" class="btn btn-primary">
</form>
@endsection