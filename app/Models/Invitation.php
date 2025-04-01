<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Invitation extends Model
{
    use HasFactory;

    protected $table = 'invitations'; // Define a tabela no banco

    protected $fillable = [
        'email',
        'token',
        'role',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime', // Converte automaticamente para um objeto Carbon
    ];

    public $timestamps = true; // Mantém created_at e updated_at

    /**
     * Verifica se o convite está expirado.
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }
}
