<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Config;

class SendMail extends Job implements SelfHandling, ShouldQueue
{

    use InteractsWithQueue, SerializesModels;

    protected $emailAddress;
    protected $emailType;
    protected $data;
    protected $subject;
    protected $from;

    public function __construct($emailAddress, $emailType, $data)
    {

        //CONFIG ITEMS
        $mail_config = Config::get('mail');

        $this->from = $mail_config['from'];
        $this->subject = $mail_config['subject'][$emailType];

        //SPECIFIC ITEMS
        $this->emailAddress = $emailAddress;
        $this->emailType = 'emails.' . $emailType;
        $this->data = $data;

    }


    public function handle(Mailer $mailer)
    {
        echo 'email job received ';

        $data           = $this->data;
        $subject        = $this->subject;
        $from           = $this->from;
        $emailType      = $this->emailType;
        $emailAddress   = $this->emailAddress;

        $mailer->send($emailType, ['data' => $data], function($message) use ($data, $from, $emailType, $subject, $emailAddress)
        {
            $message->from($from['address'], $from['name']);
            $message->to($emailAddress);
            $message->subject($subject);

        });
    }
}
