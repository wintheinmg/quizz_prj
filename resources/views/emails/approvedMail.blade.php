@extends('layouts.app')
@section('styles')
    <style>
        body {
            min-height: auto;
        }

        .container {
            width: 100% !important;
            padding-right: 0px !important;
            padding-left: 15px !important;
            margin-right: auto !important;
            margin-left: auto !important;
        }

        @media (min-width: 1000px) {
            .container {
                max-width: 100%;
            }
        }

        .form-control:focus {
            border-color: #9577fd !important;
            box-shadow: 0 0 0 0.2rem hsl(358deg 100% 36% / 25%) !important;
        }

        .scrollbar {
            margin-left: 30px;
            float: left;
            height: 300px;
            width: 65px;
            background: #F5F5F5;
            overflow-y: scroll;
            margin-bottom: 25px;
        }

        .scrollbar::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            background-color: #F5F5F5;
        }

        .scrollbar::-webkit-scrollbar {
            width: 6px;
            background-color: #F5F5F5;
        }

        .scrollbar::-webkit-scrollbar-thumb {
            background-color: #9577fd;
        }
    </style>
@endsection
@section('content')
    <div class="authentication-wrapper authentication-cover">
        <div class="authentication-inner row m-0 p-0  justify-content-center">
            <!-- Login -->
            <div style="background: #fff;
                        height: 100vh !important;
                        overflow-y:scroll;
                        display: flex;
                        justify-content: center;">
                <div style="width: 60%;">
                    <!-- Logo -->
                    <div style="background-color: #9577fd;padding: 15px 12px 15px 12px;"></div>
                    <div style="display: flex; align-items: center;">
                        <img src="https://eas.hmmdemo.net/eas-logo.jpg" alt="EAS LOGO" class="" width="80"
                        height="60" />
                        <span style="color: #636f83;
                                    margin-bottom: 0;
                                    font-size: 1.33125rem;
                                    font-weight: 500;
                                    padding: 13px;">EDUCOMM ALLIANCE SYNERGY</span>
                    </div>
                    <hr style="border: 1px solid #9577fd; background-color: #9577fd;margin: 0;">
                    <div style="padding: 0 12px;">
                        <h3>Dear,</h3>
                        <p>{{ trans('global.verifyYourUser') }} {{ trans('global.thankYouForUsingOurApplication') }}</p>
                        <p>With Regards</p>
                        <a href="https://eas.hmmdemo.net/login" 
                        style="display: inline-block;
                                font-weight: 400;
                                color: #ffffff;
                                text-decoration: none;
                                text-align: center;
                                vertical-align: middle;
                                cursor: pointer;
                                -webkit-user-select: none;
                                -moz-user-select: none;
                                -ms-user-select: none;
                                user-select: none;
                                background-color: #9577fd;
                                border: 1px solid #9577fd;
                                padding: 0.375rem 0.75rem;
                                font-size: .875rem;
                                line-height: 1.5;
                                border-radius: 0.25rem;
                                transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;">
                                {{ trans('global.gotologin') }}
                            </a>
                    </div>
                </div>
            </div>
            <!-- /Login -->
        </div>
    </div>
@endsection
