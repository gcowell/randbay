<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Jobs\SendMail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;


class MailingList extends Model
{

    use DispatchesJobs;

    protected $table = 'mailinglist';

    public function sendWeeklyMail()
    {
        $list = DB::table('mailinglist')->get();

        foreach ($list as $entry)
        {
            $emailAddress = $entry->email;
            $data =
                [
                    'id'        => $entry->id,
                    'image'     => 'weekly.jpg',
                    'image_path'=> Config::get('saleitems.filepath')
                ];

            $job = (new SendMail($emailAddress, 'weekly', $data));
            $this->dispatch($job);

        }


    }


}
