<?php

namespace App\Http\Controllers\mails;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategorizeEmailRequest;
use App\Http\Requests\MailValidationRequest;
use App\Jobs\SendEmailJob;
use App\Models\Attachment;
use App\Models\Category;
use App\Models\Email;
use App\services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Email as MimeEmail;

class MailController extends Controller
{

    /**
     * instance from MailService
     * 
     * @var \App\services\MailService
     */
    private $mailService;


    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function inbox()
    {
        $emails = Email::where('is_sent', false)->get();

        $categories = Category::all();

        return view('emails.inbox', compact('emails', 'categories'));
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

    public function showEmail(Email $email)
    {
        return view('emails.show', compact('email'));
    }


    /**
     * calling the MailService to send email, then storing emails 
     * and it's related attachments
     * 
     * @param MailValidationRequest $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendEmail(MailValidationRequest $request)
    {
        $data = $request->validated();

        $this->mailService->sendEmail($data);

        $email = Email::create([
            'from' => config('mail.from.address'),
            'to' => $data['to'],
            'subject' => $data['subject'],
            'body' => $data['body'],
            'is_sent' => true, // Sent emails
        ]);

        if (isset($data['attachments'])) {
            foreach ($data['attachments'] as $attachment) {
                Attachment::create([
                    'email_id'  => $email->id,
                    'file_name' => $attachment->getClientOriginalName(),
                    'file_path' => $attachment->store('public/attachments'),
                ]);
            }
        }

        return back()->with('success', 'Email sent successfully');
    }


    /**
     * calling the MailService to reply email, then storing emails 
     * and it's related attachments
     * 
     * @param MailValidationRequest $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function replyEmail(Request $request, Email $email)
    {
        $data = $request->all();

        $this->mailService->replyEmail($data, $email);

        return back()->with('success', 'Reply sent successfully');
    }

    /**
     * forwarding and email and storing it with its attachments
     * 
     * @param Request $request
     * @param Email $email
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
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

        return back()->with('success', 'Email forwarded successfully');
    }


    /**
     * syncing emails with categories
     * @param Request $request
     * @param Email $email
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function categorizeEmail(CategorizeEmailRequest $request, Email $email)
    {
        $email->categories()->sync($request->categories);
        return back()->with('success', 'Email categorized successfully');
    }
}
