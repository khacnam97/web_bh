@extends('layouts.admin')
@section('title', __('script.Edit Script') )
@section('content')
    <link rel="stylesheet" href="{{ asset('css/script/main.css') }}">
    <form method="POST" action="{{route('script.postEdit', $data->id)}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('script.Name') }}</label>

            <div class="col-md-6">
                <input id="username" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $data->name) }}" autocomplete="name" autofocus>

                @include('errors.alert_error', ['name'=> 'name'])
            </div>
        </div>

        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('script.Description') }}</label>

            <div class="col-md-6">
                <textarea style="height: 100px;" id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description" autofocus>{{ old('description', $data->description) }}</textarea>

                @include('errors.alert_error', ['name'=> 'description'])
            </div>
        </div>

        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('script.File') }}</label>
            <div class="col-md-6" >
                <div class="input-group">
                    <input id="fileName" name="file_name" type="text" class="form-control  @error('fileName') is-invalid @enderror" readonly value="{{ old('file_name', $data->fileName) }}" autocomplete="fileName" autofocus/>
                    <input class="d-none" id="inputFile" type="file"  name="fileName" value="{{ $data->fileName }}" accept="py">
                    <button id="btnAdd" class="btn btn-light btn-choose" style="@error('fileName') border: 1px solid #e3342f; @enderror border-left: 0;" type="button">{{ __('script.Choose File') }}</button>
                    @include('errors.alert_error', ['name'=> 'fileName'])
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('script.Status') }}</label>
            <div class="col-md-6">
                <select id="isActive" class="form-control select2bs4 @error('isActive') is-invalid @enderror" style="width: 100%;" name="isActive">
                    <option value="1" {{ old('isActive', $data->isActive) == '1' ? 'selected' : ''}}>{{__('script.execFile')}}</option>
                    <option value="0" {{ old('isActive', $data->isActive) == '0' ? 'selected' : '' }}>{{__('script.supportFile')}}</option>
                </select>
                @include('errors.alert_error', ['name'=> 'isActive'])
            </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('common.Edit') }}
                </button>
            </div>
        </div>
    </form>
    <script src="{{ asset('js/script/upload.js') }}"></script>
@endsection
