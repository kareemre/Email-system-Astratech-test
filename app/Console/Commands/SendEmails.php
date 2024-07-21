<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Email;
use Illuminate\Console\Command;
use Webklex\IMAP\Facades\Client;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:fetch';
   

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch emails from IMAP server';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = Client::account('default');
        $client->connect();
        $inbox = $client->getFolder('INBOX');
        $messages = $inbox->messages()->all()->get();

        foreach ($messages as $message) {
            $email = Email::create([
                'user_id' => 1, // Assuming user_id 1 for this example
                'from' => $message->getFrom()[0]->mail,
                'to' => $message->getTo()[0]->mail,
                'subject' => $message->getSubject(),
                'body' => $message->getTextBody(),
                'is_sent' => false, // Received emails are not sent
            ]);

            $this->categorizeEmail($email, $message->getTextBody());
        }
    }

    private function categorizeEmail($email, $body)
    {
        $categories = Category::with('keywords')->get();
        foreach ($categories as $category) {
            foreach ($category->keywords as $keyword) {
                if (stripos($body, $keyword->keyword) !== false) {
                    $email->categories()->attach($category->id);
                }
            }
        }
    }


    
}
