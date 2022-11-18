<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    public const STATES = [
        'created' => 0,
        'assigned' => 1,
        'closed' => 2,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'city_admin_id',
        'technician_id',
        'ticket_id',
        'description'
    ];

    /** Set request state
     *
     * @param $state string
     */
    public function setState($state) {
        $state = self::STATES[$state];
        if ($state) {
            $this->state = $state;
        }
    }

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
}
