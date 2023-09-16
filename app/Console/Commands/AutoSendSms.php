<?php

namespace App\Console\Commands;

use App\Jobs\SendSmsToUsers;
use App\Models\Notify\SMS;
use Illuminate\Console\Command;

class AutoSendSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:sendSms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $smsToSends=SMS::where('published_at', "=" ,now())->get();
        foreach ($smsToSends as $smsToSend){
            SendSmsToUsers::dispatch($smsToSend);
        }
    }
}
