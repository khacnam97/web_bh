@extends('layouts.admin')
@section('title', __('trans.Upload File List'))
@section('custom-header')
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.css')  }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css')  }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')  }}">

    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/analyze/main.css') }}">
@endsection

@section('content')
    <div>
        <!-- list file table -->
        <div role="tabpanel" class="tab-pane" id="list-table">
            <div class="table-wrapper">
                <table id="list" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th style="width: 30px">{{ __('trans.No') }}</th>
                        <th>{{ __('user.User name') }}</th>
                        <th>{{ __('trans.Upload Time') }}</th>
                        <th>{{ __('trans.Status') }}</th>
                        <th class="text-dark">{{ __('trans.Error') }}</th>
                        <th style="width: 115px">{{ __('trans.Download Original File') }}</th>
                        <th style="width: 120px">{{ __('trans.Download Analyze File') }}</th>
                        <th style="width: 60px">{{ __('trans.Delete Result') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($files))
                        @foreach($files as $file)
                            <tr>
                                <td>{{ $file['no'] }}</td>
                                <td>{{ $file['username'] }}</td>
                                <td>{{ $file['uploadTime'] }}</td>
                                <td>{{ $file['status'] }}</td>
                                <td class="text-info">{!! $file['analyzeError'] !!}</td>
                                <td class="text-center">{!! $file['downloadOriginal'] !!}</td>
                                <td class="text-center">{!! $file['downloadAnalyze'] !!}</td>
                                <td class="text-center">{!! $file['deleteButton'] !!}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    @include('common.data-table')
    @if(Session::get('info'))
        <script>
            let message = '{{Session::get('info')}}'
        </script>
    @else
        <script>
            let message ='';
        </script>
    @endif
    <script>
        let totalFirstLoad = parseInt('{{ $totalItem }}')
        let isAdmin = {{ Auth::user()->hasRole('admin')?'true':'false' }};
    </script>
    <script src="{{ asset('js/analyze/main.js') }}"></script>
@endsection
