<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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



    public function createEvidenceDirectory()
    {
        $evidenceStoragePath = storage_path() . '\\tickets\\';
        $ticketStoragePath = $evidenceStoragePath . $this->id;
        mkdir($ticketStoragePath, 0777);

        $this->evidence_dir = $ticketStoragePath;
        $this->save();

        return true;
    }

}
