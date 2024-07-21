<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Models\Attachment;
use App\Models\Email;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Email as MimeEmail;

class MailController extends Controller
{


    public function inbox()
    {
        $emails = Email::where('is_sent', false)->get();
        return view('emails.inbox', compact('emails'));
    }

    public function outbox()
    {
        $emails = Email::where('is_sent', true)->get();
        return view('emails.outbox', compact('emails'));
    }

    public function showSendEmailForm()
    {
        return view('emails.send_email');
    }

    public function showReplyEmailForm(Email $email)
    {
        return view('emails.reply_email', compact('email'));
    }


    public function showForwardEmailForm(Email $email)
    {
        return view('emails.forward_email', compact('email'));
    }

    
    /**
     * sending emails
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendEmail(Request $request)
    {
        $data = $request->all();

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


        $email = Email::create([
            'user_id' => auth()->id(),
            'from' => config('mail.from.address'),
            'to' => $data['to'],
            'subject' => $data['subject'],
            'body' => $data['body'],
            'is_sent' => true, // Sent emails
        ]);
    
        if (isset($data['attachments'])) {
            foreach ($data['attachments'] as $attachment) {
                Attachment::create([
                    'message_id' => $email->id,
                    'file_name' => $attachment->getClientOriginalName(),
                    'file_path' => $attachment->store('attachments'),
                ]);
            }
        }

        SendEmailJob::dispatch($data, $request->file('attachments'))->onQueue('emails');
    
        return back()->with('success', 'Email sent successfully');
    }



    public function replyEmail(Request $request, Email $email)
    {
        $data = $request->all();
        $replyBody = "Replying to:\n\n" . $email->body . "\n\n" . $data['body'];

        Mail::raw($replyBody, function ($message) use ($data, $email) {
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
        'user_id' => 2,
        'from' => config('mail.from.address'),
        'to' => $email->from,
        'subject' => 'Re: ' . $email->subject,
        'body' => $replyBody,
        'is_sent' => true, // Sent emails
        ]);

        if (isset($data['attachments'])) {
        foreach ($data['attachments'] as $attachment) {
            Attachment::create([
                'email_id' => $replyEmail->id,
                'filename' => $attachment->getClientOriginalName(),
                'path' => $attachment->store('attachments'),
            ]);
        }
    }

    SendEmailJob::dispatch($data, $request->file('attachments'))->onQueue('emails');

    return back()->with('success', 'Reply sent successfully');
}

public function forwardEmail(Request $request, Email $email)
{
    $data = $request->all();
    $forwardBody = "Forwarded message:\n\n" . $email->body . "\n\n" . $data['body'];

    Mail::raw($forwardBody, function ($message) use ($data, $email) {
        $message->from(config('mail.from.address'), config('mail.from.name'));
        $message->to($data['to']);
        $message->subject('Fwd: ' . $email->subject);

        if (isset($data['attachments'])) {
            foreach ($data['attachments'] as $attachment) {
                $message->attach($attachment->getRealPath(), [
                    'as' => $attachment->getClientOriginalName(),
                    'mime' => $attachment->getMimeType(),
                ]);
            }
        }
    });

    $forwardEmail = Email::create([
        'user_id' => 2,
        'from' => config('mail.from.address'),
        'to' => $data['to'],
        'subject' => 'Fwd: ' . $email->subject,
        'body' => $forwardBody,
        'is_sent' => true, // Sent emails
    ]);

    if (isset($data['attachments'])) {
        foreach ($data['attachments'] as $attachment) {
            Attachment::create([
                'email_id' => $forwardEmail->id,
                'filename' => $attachment->getClientOriginalName(),
                'path' => $attachment->store('attachments'),
            ]);
        }
    }

    SendEmailJob::dispatch($data, $request->file('attachments'))->onQueue('emails');

    return back()->with('success', 'Email forwarded successfully');
    }
}
