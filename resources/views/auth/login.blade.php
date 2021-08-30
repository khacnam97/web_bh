@extends('layouts.app')
@section('title', __('user.Login') )
@section('content')
<!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="#"><i class="fa fa-home"></i> Home</a>
                        <span>Login</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Form Section Begin -->
    <!-- Register Section Begin -->
    <div class="register-login-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="login-form">
                    <h2>Login</h2>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="group-input">
                            <label for="username">Username or email address *</label>
                            <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" autocomplete="username" autofocus>
                            @include('errors.alert_error', ['name'=> 'username'])
                        </div>
                        <div class="group-input">
                            <label for="pass">Password *</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">
                            @include('errors.alert_error', ['name'=> 'password'])
                            @if(Session::get('msg'))
                                <span><strong style="color: #e3342f; font-size: 80%;">{{Session::get('msg')}}</strong> </span>
                            @endif
                        </div>
                        <div class="group-input gi-check">
                            <div class="gi-more">
                                <label for="save-pass">
                                    Save Password
                                    <input type="checkbox" id="save-pass">
                                    <span class="checkmark"></span>
                                </label>
                                <a href="#" class="forget-pass">Forget your Password</a>
                            </div>
                        </div>
                        <button type="submit" class="site-btn login-btn">Sign In</button>
                    </form>
                    <div class="switch-login">
                        <a href="{{ route('getRegister') }}" class="or-login">Or Create An Account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @if(Session::get('username'))
        <script>
            let username = '{{Session::get('username')}}'
            $(function () {
                $('#username').val(username)
            })
        </script>
    @endif
@endsection
