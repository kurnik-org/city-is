<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    public const STATES = [
        'reported' => 0,
        'wip' => 1,
        'fixed' => 2,
    ];

    /** Convert string state to int.
     *
     * @param $state string
     * @return int
     */
    public static function getStateId($state): int
    {
        return self::STATES[$state];
    }

    protected $fillable = [
        'title',
        'description',
    ];

    protected $attributes = [
        'state' => self::STATES['reported']
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function service_requests()
    {
        return $this->hasMany(ServiceRequest::class);
    }
}
