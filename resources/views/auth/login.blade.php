@extends('layouts.app')

@section('title','Login')

@section('content')
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3 form-box">

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="form-top login100-form-title" style="background-image: url('/assets/login/img/backgrounds/bg.jpg');">
                <div class="form-top-left">
                    <h3>Login</h3>
                    <p>Masukan Username dan Password:</p>
                </div>
                <div class="form-top-right">
                    <i class="fa fa-lock"></i>
                </div>
            </div>

            <div class="form-bottom">
                <form method="POST" action="{{ route('login') }}" class="login-form">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="username" class="form-username form-control" placeholder="Username..." value="{{ old('username') }}">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-password form-control" placeholder="Password...">
                    </div>
                    <input type="submit" class="login-btn" value="Login">
                </form>
            </div>

        </div>
    </div>
@endsection
