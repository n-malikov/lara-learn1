<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $verify_token
 * @property string $role
 * @property string $status
 */
class User extends Authenticatable
{
    use Notifiable;

    // laralearn подтвержденный (верифицированный) или нет
    public const STATUS_WAIT = 'wait';
    public const STATUS_ACTIVE = 'active';

    public const ROLE_USER = 'user';
    public const ROLE_ADMIN = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'verify_token', 'role', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function register (string $name, string $email, string $password): self
    {
        return static::create([
            'name'    => $name,
            'email'   => $email,
            'password'=> bcrypt($password),
            'verify_token' => Str::uuid(),
            //'verify_token' => Str::random(),
            'role'    => self::ROLE_USER,
            'status'  => self::STATUS_WAIT,
        ]);
    }

    public static function newUser ($name, $email): self
    {
        return static::create([
            'name'    => $name,
            'email'   => $email,
            'password'=> bcrypt(Str::random()),
            'role'    => self::ROLE_USER,
            'status'  => self::STATUS_ACTIVE,
        ]);
    }

    public function isWait(): bool
    {
        return $this->status === self::STATUS_WAIT;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function verify(): void
    {
        if (!$this->isWait()) {
            throw new \DomainException('User is already verified.');
        }

        $this->update([
            'status' => self::STATUS_ACTIVE,
            'verify_token' => null,
        ]);
    }

    public function changeRole($role) : void
    {
        if ( !\in_array($role, [self::ROLE_USER, self::ROLE_ADMIN], true) ) {
            throw new \InvalidArgumentException("Undefined role «{$role}»");
        }
        if ($this->role === $role) {
            throw new \DomainException('Role is already assigned.');
        }
        $this->update(['role' => $role]);
    }

    public function isAdmin(): bool
    {
        return $this->role == self::ROLE_ADMIN;
    }
}
