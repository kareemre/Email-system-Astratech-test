<?php

namespace App\services;

use Illuminate\Support\Facades\Mail;

class MailService
{

    /**
     * sending and e-mail
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

}