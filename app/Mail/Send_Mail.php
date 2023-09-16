<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Send_Mail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public  $subject;
    public  $body;
    public  $files;
    public function __construct($subject,$body,$files)
    {
        $this->subject=$subject;
        $this->body=$body;
        $this->files=$files;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.Send_Mail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {

        $publicFile=[];
        if ($this->files){
            foreach ($this->files as $file){
                array_push($publicFile,public_path($file));

            }
        }
        return $publicFile;

//
//        return [
//            Attachment::fromStorageDisk('public','image_3.jpg')
//                ->as('edwin second mail.jpg')
//                ->withMime('image/jpg'),
//        ];
    }
}
