<?php

namespace App\Jobs;

use App\Models\Notify\Email;
use App\Models\Notify\EmailFile;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Attachment;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class Send_Mail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $email;


    public function __construct(Email $email)
    {
        $this->email = $email;


    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public $emailFile;
    public function handle(EmailFile $emailFile)
    {
        $this->emailFile = $emailFile;
        $users=User::whereNotNull('email')->get();
        foreach ($users as $user)
        {
            $details = [
                'title' => $this->email->subject,
                'body' => $this->email->body
            ];
            $files=$this->email->files;
            $filePaths=[];
            foreach ($files as $file){
                array_push($filePaths,$file->file_path);
            }
            $emailService=Mail::to($user->email)->queue(new \App\Mail\Send_Mail($this->email->subject,$this->email->body,$filePaths));
        }

    }

}
