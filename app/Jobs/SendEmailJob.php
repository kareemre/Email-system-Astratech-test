<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $attachments;

    /**
     * Create a new job instance.
     *
     * @param array $data
     * @param array|null $attachments
     * @return void
     */
    public function __construct(array $data, $attachments = null)
    {
        $this->data = $data;
        $this->attachments = $attachments;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::raw($this->data['body'], function ($message) {
            $message->from(config('mail.from.address'), config('mail.from.name'));
            $message->to($this->data['to']);
            $message->subject($this->data['subject']);

            if ($this->attachments) {
                foreach ($this->attachments as $attachment) {
                    $message->attach($attachment->getRealPath(), [
                        'as' => $attachment->getClientOriginalName(),
                        'mime' => $attachment->getMimeType(),
                    ]);
                }
            }
        });
    }
}
