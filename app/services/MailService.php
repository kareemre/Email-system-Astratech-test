<?php

namespace App\services;

use App\Models\Attachment;
use App\Models\Email;
use Illuminate\Support\Facades\Mail;

class MailService
{

    /**
     * sending an e-mail
     * 
     * @param array $data
     * 
     * @return void
     */
    public function sendEmail(array $data)
    {
        Mail::raw($data['body'], function ($message) use ($data) {
            $message->from(config('mail.from.address'), config('mail.from.name'));
            $message->to($data['to']);
            $message->subject($data['subject']);

            if (isset($data['attachments'])) {
                foreach ($data['attachments'] as $attachment) {
                    $message->attach($attachment->getRealPath(), [
                        'as' => $attachment->getClientOriginalName(),
                        'mime' => $attachment->getMimeType(),
                    ]);
                }
            }
        });
    }


    /**
     * replying to an e-mail
     * 
     * @param array $data
     * @param \App\Models\Email
     * 
     * @return void
     */
    public function replyEmail(array $data, $email)
    {
        $replyBody = "Replying to:\n\n" . $email->body . "\n\n" . $data['body'];

        Mail::raw($replyBody, function ($message) use ($data, $email) {

            // i am using here emails set in the config file as "from email", 
            //since i did not implemented user authentication 
            //if i apply user authentication it would be auth()->user()->email
            //but for now it is hard coded

            $message->from(config('mail.from.address'), config('mail.from.name'));
            $message->to($email->from);
            $message->subject('Re: ' . $email->subject);

            if (isset($data['attachments'])) {
                foreach ($data['attachments'] as $attachment) {
                    $message->attach($attachment->getRealPath(), [
                        'as' => $attachment->getClientOriginalName(),
                        'mime' => $attachment->getMimeType(),
                    ]);
                }
            }
        });

        $replyEmail = Email::create([
            'from'    => config('mail.from.address'),
            'to'      => $email->from,
            'subject' => 'Re: ' . $email->subject,
            'body'    => $replyBody,
            'is_sent' => true, // Sent emails
        ]);

        if (isset($data['attachments'])) {
            foreach ($data['attachments'] as $attachment) {
                Attachment::create([
                    'email_id' => $replyEmail->id,
                    'file_name' => $attachment->getClientOriginalName(),
                    'file_path' => $attachment->store('attachments'),
                ]);
            }
        }

    }


    /**
     * forwarding an e-mail
     * 
     * @param array $data
     * 
     * @return void
     */
    public function forwardEmail(array $data)
    {

    }

}