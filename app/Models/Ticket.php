<?php

namespace App\Models;

use App\Enums\TicketStateEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    /** Gets ticket's state.
     *
     * @return TicketStateEnum
     */
    public function getState()
    {
        return $this->state;
    }

    /** Sets ticket's state.
     *
     */
    public function setState(TicketStateEnum $newState)
    {
        $this->state = $newState;
    }

    protected $fillable = [
        'title',
        'description',
        'state',
    ];

    protected $attributes = [
        'state' => TicketStateEnum::REPORTED,
    ];

    protected $casts = [
        'state' => TicketStateEnum::class,
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function service_requests()
    {
        return $this->hasMany(ServiceRequest::class);
    }

    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

    public function photo_attachments()
    {
        return $this->hasMany(PhotoAttachment::class);
    }
}
