<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Invitation extends Model
{
    use HasFactory;

    protected $table = 'invitations';

    protected $fillable = [
        'email',
        'token',
        'role',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public $timestamps = true;

    /**
     *
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }
}
