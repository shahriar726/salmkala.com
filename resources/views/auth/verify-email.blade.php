<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600 justify-between text-right">
            {{ __('قبل از ادامه، آیا می توانید آدرس ایمیل خود را با کلیک بر روی پیوندی که به تازگی برای شما ایمیل کرده ایم تأیید کنید؟ اگر ایمیلی را دریافت نکردید، با کمال میل یک ایمیل دیگر برای شما ارسال خواهیم کرد.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-button type="submit">
                        {{ __('Resend Verification Email') }}
                    </x-button>
                </div>
            </form>

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
        </div>
    </x-authentication-card>
</x-guest-layout>
