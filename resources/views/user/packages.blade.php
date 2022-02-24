@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/packages.css') }}">
@endsection

@section('js')
    <script src="{{ asset('js/packages.js') }}"></script>
@endsection

@section('content')
<div class="container">
  
    <h1 class="text-center">{{ __('admin/packages.list-packages') }}</h1>
    <a href="{{ route('user-add-package') }}" class="btn btn-light float-right">&plus;{{ __('admin/packages.add_package') }}</a>

    {{-- packages colors legend --}}
    @if(Route::currentRouteName() === 'all-packages')
        <span class="badge badge-pill badge-info">{{ __('admin/packages.package_beign_delivered') }}</span>
        <span class="badge badge-pill badge-secondary">{{ __('admin/packages.package_delivered') }}</span><br>
    @endif
    <span class="badge badge-pill badge-danger">{{ __('admin/packages.package_less_1_day') }}</span><br>
    <span class="badge badge-pill badge-warning">{{ __('admin/packages.package_less_2_day') }}</span><br>
    <span class="badge badge-pill badge-primary">{{ __('admin/packages.package_less_5_day') }}</span><br>
    <span class="badge badge-pill badge-light">{{ __('admin/packages.package_more_5_day') }}</span>

    @if(count($packages) > 0)
        <table class="table">

            <thead class="thead-dark">
                <tr>
                    <th>{{ __('admin/packages.num') }}</th>
                    <th>{{ __('admin/packages.ddate') }}</th>
                    <!-- <th>{{ __('admin/packages.options') }}</th> -->
                </tr>
            </thead>

            <tbody>
                @foreach($packages as $p)
                    {{-- set the package bakground based on it's importance --}}
                    <tr class="bg-{{ \App\package::packageColor($p->delivers_date, $p->status) }}">
                        <td>{{ $p->num }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->delivers_date)->diffForHumans() }}</td>
                        <!-- <td>

                            <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle border border-dark" type="button" id="packageOptionDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('admin/packages.options') }}
                                </button>
                                <div class="dropdown-menu" aria-labelledby="packageOptionDropdown">
                                    {{-- show package information --}}
                                    <button type="button" class="btn btn-info packageInfo dropdown-item" data-toggle="modal" data-target="#packageInfoModal" data-package="{{ $p->id }}">{{ __('admin/packages.info') }}</button>
                                    {{-- mark package as delivered --}}
                                    <button type="submit" form="packageDelevered-{{ $p->id }}" class="btn btn-primary dropdown-item">{{ __('admin/packages.delivered') }}</button>
                                    {{-- edit package --}}
                                    <a href="{{ route('edit-package', ['package' => $p->id]) }}" class="dropdown-item">{{ __('admin/packages.edit_package') }}</a>
                                    <div class="dropdown-divider"></div>
                                    {{-- delete a package --}}
                                    <button type="submit" form="packageDeleted-{{ $p->id }}" class="btn btn-danger packageDeletedBtn dropdown-item">{{ __('admin/packages.delete') }}</button>
                                </div>
                            </div>

                            {{-- mark a package as delivered --}}
                            <form action="{{ route('delivered', ['package' => $p->id ]) }}" method="post" id="packageDelevered-{{ $p->id }}" class="d-none">
                                @csrf
                            </form>
                            {{-- delete pckage --}}
                            <form action="{{ route('delete-package', ['package' => $p->id]) }}" method="post" class="d-none packageDeleted" id="packageDeleted-{{ $p->id }}">
                                @csrf
                            </form>
                        </td> -->
                    </tr>
                @endforeach
            </tbody>

        </table>

        {{-- display the pagination links --}}
        {!! $packages->links() !!}

        {{-- package information modal --}}
        <div class="modal fade" id="packageInfoModal" tabindex="-1" role="dialog" aria-labelledby="packageInfoModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="packageInfoModalTitle">{{ __('admin/packages.package_num') }} <span class="packageInfoModalNum"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{-- num --}}
                        <h3 class="text-center d-block modalInfoHeading">{{ __('admin/packages.num') }}</h3>
                        <h4 class="packageInfoModalNum d-block text-center"></h4>

                        {{-- weight --}}
                        <h3 class="text-center d-block modalInfoHeading">{{ __('admin/packages.weight') }}</h3>
                        <h4 class="packageInfoModalWeight text-center"></h4>

                        {{-- delivery date --}}
                        <h3 class="text-center d-block modalInfoHeading">{{ __('admin/packages.ddate') }}</h3>
                        <h4 class="packageInfoModalDdate text-center"></h4>

                        {{-- from --}}
                        <h3 class="text-center d-block modalInfoHeading">{{ __('admin/packages.from') }}</h3>
                        <h4 class="packageInfoModalFrom text-center"></h4>
                    
                        {{-- to --}}
                        <h3 class="text-center d-block modalInfoHeading">{{ __('admin/packages.to') }}</h3>
                        <h4 class="packageInfoModalTo text-center"></h4>
                    
                        {{-- description --}}
                        <h3 class="text-center d-block modalInfoHeading">{{ __('admin/packages.desc') }}</h3>
                        <h4 class="packageInfoModalDecription text-center"></h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <h3 class="text-center">{{ __('admin/packages.no-packages') }}</h3>
    @endif
</div>
@endsection