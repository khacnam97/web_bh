@extends('layouts.admin')
@section('title', __('trans.Upload File'))
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
    <div >
        <div style="padding-left: 20px">
            ※ {{__('common.Upload notes')}}
        </div>
        <!-- upload form -->
        <div role="tabpanel" class="tab-pane show active" id="upload-file">
            <form id="mainForm" enctype="multipart/form-data">
                <div class="list-file border border-dark"></div>
                <div class="btn-section mt-10">
                    <input class="d-none" id="inputFile" type="file" name="file" accept="zip">
                    <button id="btnAdd" type="button" class="btn btn-secondary">{{ __('trans.Add') }}</button>
                    <button id="btnSubmit" type="button" class="btn btn-primary" disabled>{{ __('trans.Submit') }}</button>
                </div>
                <div class="progress d-none">
                    <div id="bar-value" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 0"></div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('custom-js')
    @include('common.data-table')
    <script src="{{ asset('js/analyze/upload.js') }}"></script>
@endsection
