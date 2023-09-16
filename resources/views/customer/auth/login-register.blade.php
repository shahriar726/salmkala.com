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
        <form action="{{ route('auth.customer.login-register') }}" method="post">
            @csrf
            <section class="login-wrapper mb-5">
                <section class="login-logo">
                    <a href="{{route('customer.home')}}"><img src="{{ asset('customer-assets/images/logo/4.png') }}" alt=""></a>
                </section>
                <section class="login-title"><a class="text-decoration-none" href="{{ route('login') }}">ورود </a> / <a class="text-decoration-none" href="{{ route('auth.customer.login-register-form') }}">ثبت نام </a></section>
                <section class="login-info">شماره موبایل یا پست الکترونیک خود را وارد کنید</section>
                <section class="login-input-text ">
                    <div class="form-group">
                    <input type="text" name="id" class=" form-control form-control-sm @error('id') is-invalid @enderror"  value="{{ old('id') }} ">
                    </div>
                    @error('id')
                    <span class="alert_required    text-white p-1 rounded" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                    @enderror
                </section>
                <section class="login-btn d-grid g-2"><button class="btn btn-danger">ورود به آمازون</button></section>
{{--                <section class="login-terms-and-conditions"><a class="text-decoration-none fill-black" href="{{ route('login') }}">ورود </a></section>--}}
            </section>
        </form>
    </section>


@endsection
