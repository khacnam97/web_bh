@extends('layouts.admin')
@section('title', __('script.List Script') )
@section('content')
    <link rel="stylesheet" href="{{ asset('css/script/main.css') }}">

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm">
                <section class="content">
                    <a href="{{route('script.getCreate')}}" class="btn btn-primary btn-sm float-sm-right"> <i class="fas fa-plus" ></i> {{__('common.Create')}}</a>
                    <table id="script-table" class="table table-bordered table-hover responsive" style="width:100%">
                        <thead>
                        <tr>
                            <th>{{ __('script.Name') }}</th>
                            <th>{{ __('script.Description') }}</th>
                            <th>{{ __('script.File Name') }}</th>
                            <th>{{ __('script.Status') }}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($data['listScript']))
                            @foreach($data['listScript']['scripts'] as $script)
                                <tr>
                                    <td>{{ $script['name'] }}</td>
                                    <td>{!! $script['description'] !!}</td>
                                    <td>{{ $script['fileName'] }}</td>
                                    <td>{{ $script['isActive'] }}</td>
                                    <td>{!! $script['action'] !!}</td>
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
        let totalFirstLoad = parseInt('{{ $data['listScript']['totalItem'] }}')
    </script>
    <script src="{{ asset('js/script/index.js') }}"></script>
@endsection
