<?php

namespace App\Jobs;

use App\Http\Services\Message\MessageSerivce;
use App\Http\Services\Message\SMS\SmsService;
use App\Models\Notify\SMS;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class SendSmsToUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $sms;
    public function __construct(SMS $sms)
    {
        $this->sms = $sms;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users=User::whereNotNull('mobile')->get();
        foreach ($users as $user)
        {
            //send sms
            $smsService = new SmsService();
            $smsService->setFrom(Config::get('sms.otp_from'));
            $smsService->setTo(['0' . $user->mobile]);
            $smsService->setText($this->sms->body);
            $smsService->setIsFlash(true);
            $messagesService = new MessageSerivce($smsService);
            $messagesService->send();

        }

    }
}
