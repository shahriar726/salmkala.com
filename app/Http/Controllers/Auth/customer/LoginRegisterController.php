<?php

namespace App\Http\Controllers\Auth\customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Customer\LoginRegisterRequest;
use App\Http\Services\Message\Email\EmailService;
use App\Http\Services\Message\MessageSerivce;
use App\Http\Services\Message\SMS\SmsService;
use App\Mail\Send_otp;
use App\Models\Otp;
use App\Models\User;
use App\Notifications\NewUserRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class LoginRegisterController extends Controller
{
    public function loginRegisterForm()
    {
        return view('customer.auth.login-register');
    }

    public function loginRegister(LoginRegisterRequest $request)
    {
        $inputs = $request->all();

        //check id is email or not
        if(filter_var($inputs['id'], FILTER_VALIDATE_EMAIL))
        {
            $type = 1; // 1 => email
            $user = User::where('email', $inputs['id'])->first();
            if(empty($user)){
                $newUser['email'] = $inputs['id'];
            }
        }

        //check id is mobile or not
        elseif(preg_match('/^(\+98|98|0)9\d{9}$/', $inputs['id'])){
            $type = 0; // 0 => mobile;


            // all mobile numbers are in on format 9** *** ***
//            $inputs['id'] = ltrim($inputs['id'], '0');
            $inputs['id'] = substr($inputs['id'], 0, 2) === '98' ? substr($inputs['id'], 2) : $inputs['id'];
            $inputs['id'] = str_replace('+98', '', $inputs['id']);

            $user = User::where('mobile', $inputs['id'])->first();
            if(empty($user)){
                $newUser['mobile'] = $inputs['id'];
            }
        }

        else{
            $errorText = 'شناسه ورودی شما نه شماره موبایل است نه ایمیل';
            return redirect()->route('auth.customer.login-register-form')->withErrors(['id' => $errorText]);
        }

        if(empty($user)){
            $newUser['password'] = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // password;
            $newUser['activation'] = 1;
            $user = User::create($newUser);
        }

        //create otp code
        $otpCode = rand(111111, 999999);
        $token = Str::random(60);
        $otpInputs = [
            'token' => $token,
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'login_id' => $inputs['id'],
            'type' => $type,
        ];

        Otp::create($otpInputs);

        //send sms or email
        if($type == 0){
            //send sms
            $smsService = new SmsService();
            $smsService->setFrom(Config::get('sms.otp_from'));
            //be koja mikhahim send konim
            $smsService->setTo([ $user->mobile]);
            //matni ke mikhahi vared bokoni
            $smsService->setText("مجموعه سلم کالا \n  کد تایید : $otpCode");
            $smsService->setIsFlash(true);

            $messagesService = new MessageSerivce($smsService);
            $messagesService->send();
            $details=[
                'message'=>'یک کاربر جدید در سایت وارد شد'.' '.$user->mobile
            ];
            $adminUser=User::where('user_type', 1)->first();
            $adminUser->notify(new NewUserRegistered($details));
        }
        elseif($type === 1){

            $emailService=Mail::to($inputs['id'])->send(new Send_otp($otpCode));
            $details=[
                'message'=>'یک کاربر جدید در سایت ثبت نام کرد'.$user->email.' '.$user->mobile
            ];
            $adminUser=User::where('user_type', 1)->first();
            $adminUser->notify(new NewUserRegistered($details));

        }

        return redirect()->route('auth.customer.login-confirm-form', $token);


    }
    public function loginConfirmForm($token){
        //dalil inke token ersal kardim ine ke otp ro azash begirim
        //oon tokeni ke mifresti ro begir ba token otp = qharar bede
        $otp = Otp::where('token', $token)->first();
        if(empty($otp))
        {
            return redirect()->route('auth.customer.login-register-form')->withErrors(['id' => 'آدرس وارد شده نامعتبر میباشد']);
        }
        return view('customer.auth.login-confirm', compact('token', 'otp'));
    }


    public function loginConfirm($token, LoginRegisterRequest $request)
    {
        $inputs = $request->all();

            // timi ke **otp** create shode  >= 5 min az alan bashe
        $otp = Otp::where('token', $token)->where('used', 0)->where('created_at', '>=', Carbon::now()->subMinute(5)->toDateTimeString())->first();
        if(empty($otp))
        {
            return redirect()->route('auth.customer.login-register-form', $token)->withErrors(['id' => 'آدرس وارد شده نامعتبر میباشد']);
        }

        //if otp not match
        //$inputs['otp'] inputi ke user vared karadm
        if($otp->otp_code !== $inputs['otp'])
        {
            return redirect()->route('auth.customer.login-confirm-form', $token)->withErrors(['otp' => 'کد وارد شده صحیح نمیباشد']);
        }

        // if everything is ok :
        $otp->update(['used' => 1]);
        $user = $otp->user()->first();
        if($otp->type == 0 && empty($user->mobile_verified_at))
        {
            $user->update(['mobile_verified_at' => Carbon::now()]);
        }
        elseif($otp->type == 1 && empty($user->email_verified_at))
        {
            $user->update(['email_verified_at' => Carbon::now()]);
        }
        Auth::login($user);
        return redirect()->route('customer.home');
    }

    //ersal mojadad otp code
    public function loginResendOtp($token)
    {
        //dalil inke token ersal kardim ine ke otp ro azash begirim
        //va created_at <= 5 min qhabl bashe
        $otp = Otp::where('token', $token)->where('created_at', '<=', Carbon::now()->subMinutes(5)->toDateTimeString())->first();

        if(empty($otp))
        {
            return redirect()->route('auth.customer.login-register-form', $token)->withErrors(['id' => 'ادرس وارد شده نامعتبر است']);
        }


//  baraye 'user_id' => $user->id,
        // va $otp->type
        $user = $otp->user()->first();
        //create otp code
        $otpCode = rand(111111, 999999);
        $token = Str::random(60);
        $otpInputs = [
            'token' => $token,
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'login_id' => $otp->login_id,
            'type' => $otp->type,
        ];

        Otp::create($otpInputs);

        //send sms or email

        if($otp->type == 0){
            //send sms
            $smsService = new SmsService();
            $smsService->setFrom(Config::get('sms.otp_from'));
            $smsService->setTo([ $user->mobile]);
            $smsService->setText("مجموعه سلم کالا \n  کد تایید : $otpCode");
            $smsService->setIsFlash(true);

            $messagesService = new MessageSerivce($smsService);
            $messagesService->send();
        }

        elseif($otp->type === 1){

            $emailService=Mail::to($otp->login_id)->send(new Send_otp($otpCode));

        }



        return redirect()->route('auth.customer.login-confirm-form', $token);

    }

    public function logout(){

        Auth::logout();
        return redirect()->route('customer.home');
    }




}
