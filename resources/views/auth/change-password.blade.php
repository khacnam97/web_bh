@extends('layouts.admin')
@section('title', __('admin.Change Password') )
@section('content')
    <form method="POST" action="{{ route('postChangePassword') }}">
        @csrf

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('user.Current Password') }}</label>

            <div class="col-md-6">
                <input id="current_password" value="{{ old('current_password') }}" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" autocomplete="current-password" autofocus>

                @include('errors.alert_error', ['name'=> 'current_password'])
            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('user.Password New') }}</label>

            <div class="col-md-6">
                <input id="password" type="password" value="{{ old('password') }}" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">

                @include('errors.alert_error', ['name'=> 'password'])
            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('user.Password Confirmation') }}</label>

            <div class="col-md-6">
                <input id="password_confirmation" value="{{ old('password_confirmation') }}" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" autocomplete="current-password">

                @include('errors.alert_error', ['name'=> 'password_confirmation'])
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('user.Change') }}
                </button>
            </div>
        </div>
    </form>
@endsection
