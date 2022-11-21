<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'filepath',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
