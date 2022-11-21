<?php

namespace App\Models;

use App\Enums\ServiceRequestStateEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'city_admin_id',
        'technician_id',
        'ticket_id',
        'title',
        'state'
    ];

    /** Sets request's state.
     *
     */
    public function setState(ServiceRequestStateEnum $state) {
        $this->state = $state;
    }

    /** Gets ticket's state.
     *
     * @return ServiceRequestStateEnum
     */
    public function getState()
    {
        return $this->state;
    }

    protected $attributes = [
        'state' => ServiceRequestStateEnum::ASSIGNED,
    ];

    protected $casts = [
        'state' => ServiceRequestStateEnum::class,
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function city_admin()
    {
        return $this->belongsTo(User::class, 'city_admin_id', 'id');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id', 'id');
    }

    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

}
