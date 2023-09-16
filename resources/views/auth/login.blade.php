
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
        .alert_required{
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
                    <a href="{{route('customer.home')}}"><img src="{{ asset('customer-assets/images/logo/4.png') }}" alt=""></a>
                </section>
                <section class="login-title"><a class="text-decoration-none" href="{{ route('login') }}">ورود </a> / <a class="text-decoration-none" href="{{ route('auth.customer.login-register-form') }}">ثبت نام </a></section>
                <section class="login-info">شماره موبایل  یا پست الکترونیک خود را وارد کنید</section>
                <section class="login-input-text ">
                    <div class="form-group">
{{--                        <label for="login">شماره موبایل یا پست الکترونیک</label>--}}
                        <input type="text"   name="login" class=" form-control form-control-sm @error('login') is-invalid @enderror"   value="{{ old('login') }} ">
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
                        <input type="password" placeholder="رمز عبور خود را وارد کنید" name="password" class=" form-control form-control-sm @error('password') is-invalid @enderror">
                    </div>
                    @error('password')
                    <span class="alert_required    text-white p-1 rounded" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                    @enderror
                </section>
                <section class="login-btn d-grid g-2"><button class="btn btn-danger">ورود به آمازون</button></section>
                <section class="login-terms-and-conditions"><a class="text-decoration-none" href="{{ route('auth.customer.login-register-form') }}">رمزعبور خود را فراموش کردم</a></section>
            </section>
        </form>
    </section>


@endsection

