@extends('customer.layouts.master-simple')
@section('head-tag')
    <title>فراموشی رمز ورود</title>
    <style>
        .alert_required {
            color: #ff50a1 !important;
        }
    </style>

@endsection
@section('content')


    <section class="vh-100 d-flex justify-content-center align-items-center pb-5">
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <section class="login-wrapper mb-5">
                <section class="login-logo">
                    <a href="{{route('customer.home')}}"><img src="{{ asset('customer-assets/images/logo/4.png') }}"
                                                              alt=""></a>
                </section>
                <div class="mb-4 text-sm text-gray-600">
                    {{ __('رمز عبور خود را فراموش کرده اید؟ مشکلی نیست. فقط آدرس ایمیل خود را به ما اطلاع دهید و ما یک پیوند بازنشانی رمز عبور را برای شما ایمیل می کنیم که به شما امکان می دهد رمز جدیدی را انتخاب کنید.') }}
                </div>
                @if (session('status'))
                    <div class="text-success">
                        {{ __('پیوند بازنشانی رمزعبور شماراایمیل شد!') }}
                    </div>
                @endif
                <section class="login-input-text ">
                    <div class="block">
                        <x-label for="email" value="{{ __('ایمیل') }}"/>
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                                 required autofocus autocomplete="username"/>
                    </div>
                    @error('email')
                    <span class="alert_required    text-white p-1 rounded" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                    @enderror
                </section>
                <section class="login-btn d-grid g-2">
                    <button class="btn btn-danger">پیوند بازنشانی رمز عبور ایمیل</button>
                </section>

            </section>
        </form>
    </section>


@endsection







{{--<x-guest-layout>--}}
{{--    <x-authentication-card>--}}
{{--        <x-slot name="logo">--}}
{{--            <x-authentication-card-logo />--}}
{{--        </x-slot>--}}

{{--        <div class="mb-4 text-sm text-gray-600">--}}
{{--            {{ __('رمز عبور خود را فراموش کرده اید؟ مشکلی نیست. فقط آدرس ایمیل خود را به ما اطلاع دهید و ما یک پیوند بازنشانی رمز عبور را برای شما ایمیل می کنیم که به شما امکان می دهد رمز جدیدی را انتخاب کنید.') }}--}}
{{--        </div>--}}

{{--        @if (session('status'))--}}
{{--            <div class="mb-4 font-medium text-sm text-green-600">--}}
{{--                {{ session('status') }}--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        <x-validation-errors class="mb-4" />--}}

{{--        <form method="POST" action="{{ route('password.email') }}">--}}
{{--            @csrf--}}

{{--            <div class="block">--}}
{{--                <x-label for="email" value="{{ __('Email') }}" />--}}
{{--                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />--}}
{{--            </div>--}}

{{--            <div class="flex items-center justify-end mt-4">--}}
{{--                <x-button>--}}
{{--                    {{ __('Email Password Reset Link') }}--}}
{{--                </x-button>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </x-authentication-card>--}}
{{--</x-guest-layout>--}}
