<?php

namespace App\Models;

use App\Enums\UsuarioStatus;
use App\Enums\UsuarioTipo;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends User
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'email',
        'senha',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'senha',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'senha' => 'hashed',
            'status' => UsuarioStatus::class,
            'tipo' => UsuarioTipo::class,
        ];
    }

    public function unidades()
    {
        // return $this->belongsToMany(Unidade::class, 'unidade_usuario', 'usuario_id', 'unidade_id');
        return $this->belongsToMany(Unidade::class, 'unidade_usuario', 'usuario_id', 'unidade_id')
            ->withPivot('tipo')
            ->withTimestamps()
            ->using(UnidadeUsuario::class);
    }
}
