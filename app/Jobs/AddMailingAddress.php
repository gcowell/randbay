<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\MailingList;

class AddMailingAddress extends Job implements SelfHandling, ShouldQueue
{

    use InteractsWithQueue, SerializesModels;

    protected $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        echo 'address received';

        $mailinglist = new MailingList();

        if ($mailinglist->where('email', '=', $this->email)->exists())
        {
            echo ' - already registered. ';

            return;
        }
        else
        {
            $mailinglist->email = $this->email;
            $mailinglist->save();

            echo ' - address added. ';

            return;
        }
    }
}
