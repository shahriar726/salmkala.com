<x-mail::message>
<h1>ایمیل فعال سازی</h1>

کد احراز هویت:**{{$otpCode}}**

<x-mail::button :url="$url">
Button Text
</x-mail::button>
<h5>  password رمز شما  </h5>
<h5>برای تغییر در پنل کاربری اقدام کنید</h5>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
