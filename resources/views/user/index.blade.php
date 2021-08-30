@extends('layouts.admin')
@section('title', __('user.List User') )
@section('content')
    <link rel="stylesheet" href="{{ asset('css/user/main.css') }}">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <section class="content">
                    <a href="{{route('user.getCreate')}}" class="btn btn-primary btn-sm float-sm-right"> <i class="fa fa-user-plus"></i> {{__('common.Create')}}</a>
                    <table id="user-table" class="table table-bordered table-hover responsive" style="width:100%">
                        <thead>
                        <tr>
                            <th>{{ __('common.Id') }}</th>
                            <th>{{ __('user.User name') }}</th>
                            <th>{{ __('user.Full Name') }}</th>
                            <th>{{ __('user.Phone Number') }}</th>
                            <th>{{ __('user.Center Name') }}</th>
                            <th>{{ __('user.Role') }}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($data['users']))
                            @foreach($data['users'] as $user)
                                <tr>
                                    <td></td>
                                    <td>{{ $user['username'] }}</td>
                                    <td>{{ $user['full_name'] }}</td>
                                    <td>{{ $user['phone_number'] }}</td>
                                    <td>{{ $user['center_name'] }}</td>
                                    <td>{{ $user['role'] }}</td>
                                    <td>{!! $user['action'] !!}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </section>
            </div>
        </div>
    </div>
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
        let totalFirstLoad = parseInt('{{ $data['totalItem'] }}')
    </script>
    <script src="{{ asset('js/user/index.js') }}"></script>
@endsection
