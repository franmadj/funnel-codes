@extends('spark::layouts.login')

@section('content')
<div class="container">
    <div class="app">
        <!-- START APP CONTAINER -->
        <div class="app-container">
            <div class="app-login-box">
                <div class="app-login-box-user"><img src="{{asset('img/funnelcodes-logo.png')}}" alt="John Doe"></div>
                <div class="app-login-box-title">
                    <div class="title">Already a member?</div>
                    <div class="subtitle">Sign in to your account</div>
                </div>
                <div class="app-login-box-container">
                    @include('spark::shared.errors')
                    <form role="form" method="POST" action="/login">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email Address" autofocus required>
                        </div>
                        <!-- E-Mail Address -->
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 col-xs-6">
                                    <div class="app-checkbox">
                                        <label><input type="checkbox" name="remember" > Remember me <span></span></label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <button type="submit" class="btn btn-success btn-block">Sign In</button>
                                </div>
                                <p class="text-center"><a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a></p>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="app-login-box-or">
                    <div class="or">OR</div>
                </div>
                <div class="app-login-box-container">
                    <a href="/register" class="btn btn-success btn-block">Create New Account</a>
<!--                    <button class="btn btn-facebook btn-block">Connect With Facebook</button>
                    <button class="btn btn-twitter btn-block">Connect With Twitter</button>-->
                </div>
                <div class="app-login-box-footer">
                    &copy; Funnel Codes {{date('Y')}}. All rights reserved.
                    <p><a href="{{url('/')}}"> Back to website </a></p>

                </div>
            </div>

        </div>
    </div>
    @endsection
