<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SupportTicket extends Model
{
    protected $fillable =
        [
            'transaction_id',
            'type',
            'complainer_id',
            'details',
            'complainee_id',
            'resolved',
            'evidence_added'
        ];

    protected $dates = ['created_at', 'updated_at'];

    public function transaction()
    {
        return $this->belongsTo('App\Transaction', 'transaction_id');
    }

//**********************************************************************************************************************

    //CREATES A DIRECTORY FOR UPLOADING EVIDENCE IMAGES ON OPEN TICKETS
    public function createEvidenceDirectory()
    {
        $evidenceStoragePath = storage_path() . '\\tickets\\';
        $ticketStoragePath = $evidenceStoragePath . $this->id;

        if (!file_exists($ticketStoragePath))
        {
            mkdir($ticketStoragePath, 0777);
        }

        $this->evidence_dir = $ticketStoragePath;
        $this->save();

        return true;
    }

//**********************************************************************************************************************

    //RETURN ALL OPEN TICKETS
    public function getOpenTickets()
    {
        $open_tickets = DB::Table('support_tickets')
            ->select('*')
            ->where('resolved', '=', 'false')
            ->orderBy("created_at", 'ASC')
            ->take(10)
            ->get();

        return $open_tickets;
    }

//**********************************************************************************************************************

    //RESOLVES A TICKET
    public function resolve($result)
    {
        $this->result = $result;
        $this->resolved = 'true';
        $this->save();

        return true;
    }

}
