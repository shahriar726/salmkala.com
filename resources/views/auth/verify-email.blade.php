@extends('customer.layouts.master-simple')
@section('head-tag')
    <title>احراز هویت</title>

@endsection
@section('content')
    <section class="vh-100 d-flex justify-content-center align-items-center pb-5">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <section class="login-wrapper mb-5">
                <section class="login-logo">
                    <a href="{{route('customer.home')}}"><img src="{{ asset('customer-assets/images/logo/4.png') }}" alt=""></a>
                </section>
{{--                <section class="login-info">شماره موبایل  یا پست الکترونیک خود را وارد کنید</section>--}}
                <section class="login-input-text ">
                    <div class="form-group">
                        {{ __('قبل از ادامه، آیا می توانید آدرس ایمیل خود را با کلیک بر روی پیوندی که به تازگی برای شما ایمیل کرده ایم تأیید کنید؟ ') }}
                    </div>
                    @if (session('status') == 'verification-link-sent')
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ __('یک پیوند تأیید جدید به آدرس ایمیلی که در تنظیمات نمایه خود ارائه کرده اید ارسال شده است.') }}
                        </div>
                    @endif
                </section>
                <section class="login-btn d-grid g-2"><button class="btn btn-danger">  {{ __('ایمیل تایید را دوباره بفرست') }}</button></section>
            </section>
        </form>
    </section>



@endsection
{{--<x-guest-layout>--}}
{{--    <x-authentication-card>--}}
{{--        <x-slot name="logo">--}}
{{--            <x-authentication-card-logo />--}}
{{--        </x-slot>--}}

{{--        <div class="mb-4 text-sm text-gray-600 justify-between text-right">--}}
{{--            {{ __('قبل از ادامه، آیا می توانید آدرس ایمیل خود را با کلیک بر روی پیوندی که به تازگی برای شما ایمیل کرده ایم تأیید کنید؟ اگر ایمیلی را دریافت نکردید، با کمال میل یک ایمیل دیگر برای شما ارسال خواهیم کرد.') }}--}}
{{--        </div>--}}

{{--        @if (session('status') == 'verification-link-sent')--}}
{{--            <div class="mb-4 font-medium text-sm text-green-600">--}}
{{--                {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        <div class="mt-4 flex items-center justify-between">--}}
{{--            <form method="POST" action="{{ route('verification.send') }}">--}}
{{--                @csrf--}}

{{--                <div>--}}
{{--                    <x-button type="submit" >--}}
{{--                        {{ __('ایمیل تایید را دوباره بفرست') }}--}}
{{--                    </x-button>--}}
{{--                </div>--}}
{{--            </form>--}}

{{--            <div>--}}
{{--                <a--}}
{{--                    href="{{ route('profile.show') }}"--}}
{{--                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"--}}
{{--                >--}}
{{--                    {{ __('Edit Profile') }}</a>--}}

{{--                <form method="POST" action="{{ route('logout') }}" class="inline">--}}
{{--                    @csrf--}}

{{--                    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ml-2">--}}
{{--                        {{ __('Log Out') }}--}}
{{--                    </button>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </x-authentication-card>--}}
{{--</x-guest-layout>--}}
