<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /** User role's
     *
     * @var int[]
     */
    public const ROLES = [
        'admin' => 0,
        'citizen' => 1,
        'technician' => 2,
        'city_admin' => 3,
    ];

    /** Create a new citizen from request.
     *
     * Doesn't save it into the database. Transforms password into hash.
     * @param $request
     * @return User
     */
    public static function createCitizen($request): User
    {
        $user = new User();
        $user->fill($request->all());
        $user->setRole('citizen');
        $user->password = Hash::make($request->password);
        return $user;
    }

    /** Get role id
     *
     * @param $role string
     * @return int|mixed role_id or null
     */
    public static function getRoleId($role)
    {
        return self::ROLES[$role];
    }

    /** Set user's role
     *
     * @param $role string the name of the role that should be assigned
     * @return void
     */
    public function setRole($role)
    {
        $roleId = self::getRoleId($role);
        if ($roleId) {
            $this->role_id = $roleId;
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'author_id', 'id');
    }

    public function service_requests()
    {
        if ($this->role_id == self::getRoleId('technician')) {
            return $this->hasOne(ServiceRequest::class, 'technician_id', 'id');
        } else {
            return $this->hasOne(ServiceRequest::class, 'city_admin_id', 'id');
        }
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'author_id', 'id');
    }
}
