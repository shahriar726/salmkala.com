<x-mail::message>
<h1>ایمیل فعال سازی</h1>

کد احراز هویت:**{{$otpCode}}**

<x-mail::button :url="$url">
<h1>ورود به سلم کالا</h1>
</x-mail::button>
<h5>  لطفا با فراموشی رمز ورود  </h5>
<h5>رمز خود را تغییر دهید</h5>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
