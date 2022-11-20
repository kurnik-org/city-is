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

    /** Get state as a user-friendly string.
     *
     * @param $stateId int
     * @return string
     */
    public static function getStateAsUserFriendlyString($stateId): string
    {
        if ($stateId == 0) {
            return 'Reported';
        }

        if ($stateId == 1) {
            return 'Work in progress';
        }

        return 'Solved';
    }

    /** Gets ticket's state.
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    protected $fillable = [
        'title',
        'description',
        'state',
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

    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }
}
