@extends('layouts.app')

@section('css')

@endsection

@section('content')
<div class="container">
    <h1 class="text-center">{{ __('admin/deliverers.list-deliverers') }}</h1>

    @if(count($users) > 0)
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
                        <td>{{ $u->email }} {{ $u->id }}</td>
                        <td>{{ $u->phone }}</td>
                        <td>{{ $u->cin }}</td>
                        <td>{{ \Carbon\Carbon::parse($u->created_at)->diffForHumans() }}</td>
                        <td>
                            {{-- make user a deliverer --}}
                            <form action="{{ route('remove-deliverer') }}" method="post" class="d-none" id="remove-deliverer-{{ $u->id }}">
                                @csrf
                                {{-- user --}}
                                <input type="hidden" name="user" value="{{ $u->id }}">
                            </form>
                            <button class="btn btn-danger" type="submit" form="remove-deliverer-{{ $u->id }}">{{ __('admin/deliverers.remove-deliverer') }}</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- users pagination links --}}
        {!! $users->links() !!}
    @else
        <h3 class="text-center">{{ __('admin/deliverers.no-deliverers') }}</h3>
    @endif
</div>
@endsection