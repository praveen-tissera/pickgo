@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table">

        <thead class="thead-dark">
            <tr>
                <th>{{ __('admin/home.name') }}</th>
                <th>{{ __('admin/home.email') }}</th>
                <th>{{ __('admin/home.phone') }}</th>
                <th>{{ __('admin/home.cin') }}</th>
                <th>{{ __('admin/home.register-date') }}</th>
                <th>{{ __('admin/home.action') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach($users as $u)
                <tr>
                    <td>{{ $u->firstname . ' ' . $u->lastname }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->phone }}</td>
                    <td>{{ $u->cin }}</td>
                    <td>{{ \Carbon\Carbon::parse($u->created_at)->diffForHumans() }}</td>
                    <td>
                        {{-- make user a deliverer --}}
                        <form action="{{ route('make-deliverer') }}" method="post" class="d-none" id="make-deliverer">
                            @csrf
                            {{-- user --}}
                            <input type="hidden" name="user" value="{{ $u->id }}">
                        </form>
                        <button class="btn btn-info" type="submit" form="make-deliverer">{{ __('admin/home.make-deliverer') }}</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection