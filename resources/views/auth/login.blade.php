@extends('layouts.app')
@section('styles')
<style>
    body {
        min-height: auto;
    }
    
    .container{
            width: 100% !important;
            padding-right: 0px !important;
            padding-left: 15px !important;
            margin-right: auto !important;
            margin-left: auto !important;
        }
        @media (min-width: 1000px){
            .container {
                max-width: 100%;
            }
        }
        .form-control:focus {
            border-color: #9577fd !important;
            box-shadow: 0 0 0 0.2rem rgb(149 119 253 / 25%) !important;
        }
        .btn-purple{
            color: #fff;
            background-color: #9577fd;
            border-color: #9577fd;
        }
        .btn-purple:hover,
        .btn-purple:focus{
            color: #fff;
            background-color: #9477fddc;
            border-color: #9577fd;
        }
        
</style>
@endsection
@section('content')
<div class="authentication-wrapper authentication-cover">
    <div class="authentication-inner row m-0 p-0">
        <!-- /Left Text -->
        <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center">
            <div class="flex-row text-center mx-auto">
                <img src="{{ asset('quizz-login.jpg') }}" alt="Auth Cover Bg color" width="400" class="img-fluid authentication-cover-img"/>
                <div class="mx-auto">
                    <h3>QUIZZ SAMPLE</h3>
                    </p>
                </div>
            </div>
        </div>
        <!-- /Left Text -->
    
        <!-- Login -->
        <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4 m-0" style="background: #fff;height : 100vh !important">
            <div class="w-px-400 mx-auto">
                <!-- Logo -->
                <div class="app-brand mb-4">
                    <a href="/" class="app-brand-link gap-2 mb-2">
                        <!-- {{-- <span class="app-brand-logo demo">
                                <img src="{{ asset('hmmlogo.png') }}" style="width: 26px;height:26px;" alt="">
                            </span> --}} -->
                        <span class="app-brand-text demo h3 mb-0 fw-bolder text-dark">QUIZZ SAMPLE</span>
                    </a>
                </div>
                <!-- /Logo -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('failed'))
                    <div class="alert alert-danger">
                        {{ session('failed') }}
                    </div>
                @endif
                <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email </label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email or username" autofocus />
                        @if ($errors->has('email'))
                        <div class="small text-danger">
                            {{ $errors->first('email') }}
                        </div>
                        @endif
                    </div>
                    <div class="mb-3 form-password-toggle">
                        <div class="d-flex justify-content-between">
                            <label class="form-label" for="password">Password</label>
                            <!-- {{-- <a href="auth-forgot-password-cover.html">
                                    <small>Forgot Password?</small>
                                </a> --}} -->
                        </div>
                        <!-- {{-- <div class="input-group input-group-merge"> --}} -->
                        <fieldset class="form-group position-relative">
                            <input type="password" class="form-control" id="password" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;">
                            <div class="form-control-position">
                                <i class="bx bx-show mb-1" id="pwd-show"></i>
                            </div>
                        </fieldset>
                        <!-- {{-- <input type="password" id="password" class="form-control" name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password" />
                                <span class="input-group-text cursor-pointer" id="pwd-show"><i
                                        class="bx bx-hide"></i></span> --}} -->
                        @if ($errors->has('password'))
                        <div class="small text-danger">
                            {{ $errors->first('password') }}
                        </div>
                        @endif
                        <!-- {{-- </div> --}} -->
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" name="remember" type="checkbox" id="remember-me" />
                            <label class="form-check-label" for="remember-me"> Remember Me </label>
                        </div>
                    </div>
                    <button class="btn btn-purple d-grid w-100" id="sign-in">Sign in</button>
                    <a href="{{ route('register') }}" class="btn btn-purple d-grid w-100 my-1" id="sign-up">Sign up as a student</a>
                </form>
            </div>
        </div>
        <!-- /Login -->
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    if (localStorage.chkbx && localStorage.chkbx != '') {
                    $('#remember-me').attr('checked', 'checked');
                    $('#email').val(localStorage.email);
                    $('#password').val(localStorage.password);
                } else {
                    $('#remember-me').removeAttr('checked');
                    $('#email').val('');
                    $('#password').val('');
                }
                $('#sign-in').on('click',function(){
                    if ($('#remember-me').is(':checked')) {
                        // save username and password
                        localStorage.email = $('#email').val();
                        localStorage.password = $('#password').val();
                        localStorage.chkbx = $('#remember-me').val();
                    } else {
                        localStorage.email = '';
                        localStorage.password = '';
                        localStorage.chkbx = '';
                    }  
                })
    
</script>
@endsection