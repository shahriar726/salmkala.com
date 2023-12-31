{{--            <div class="flex items-center justify-end mt-4">--}}
{{--                @if (Route::has('password.request'))--}}
{{--                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">--}}
{{--                        {{ __('Forgot your password?') }}--}}
{{--                    </a>    --}}
{{--                @endif--}}
@extends('customer.layouts.master-simple')
@section('head-tag')
    <title>ورود/ثبت نام</title>
    <style>
        .alert_required {
            color: #ff50a1 !important;
        }
    </style>

@endsection
@section('content')


    <section class="vh-100 d-flex justify-content-center align-items-center pb-5">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <section class="login-wrapper mb-5">
                <section class="login-logo">
                    <a href="{{route('customer.home')}}"><img src="{{ asset('customer-assets/images/logo/4.png') }}"
                                                              alt=""></a>
                </section>
                <section class="login-title"><a class="text-decoration-none" href="{{ route('login') }}">ورود </a> / <a
                        class="text-decoration-none" href="{{ route('register') }}">ثبت نام </a></section>
                {{--                <section class="login-info">شماره موبایل  یا پست الکترونیک خود را وارد کنید</section>--}}
                <section class="login-input-text ">
                    <div class="form-group">
                        <x-label for="login" value="{{ __('شماره موبایل  یا پست الکترونیک') }}"/>
                        <input type="text" name="login"
                               class=" form-control form-control-sm @error('login') is-invalid @enderror"
                               value="{{ old('login') }} ">
                    </div>
                    @error('login')
                    <span class="alert_required    text-white p-1 rounded" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                    @enderror
                </section>
                <section class="login-input-text ">
                    <div class="form-group">
                        <x-label for="password" value="{{ __('رمز') }}"/>
                        <input type="password" name="password"
                               class=" form-control form-control-sm @error('password') is-invalid @enderror">
                    </div>
                    @error('password')
                    <span class="alert_required    text-white p-1 rounded" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                    @enderror
                </section>
                <section class="login-btn d-grid g-2">
                    <button class="btn btn-danger">ورود به فروشگاه</button>
                </section>


                @if (Route::has('password.request'))
                    <section class="login-terms-and-conditions"><a
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('password.request') }}">رمزعبور خود را فراموش کردم</a></section>
                @endif
            </section>
        </form>
    </section>


@endsection

