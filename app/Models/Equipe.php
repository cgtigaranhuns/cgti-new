<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    use HasFactory;

    protected $table = 'equipe';

    protected $fillable = [
        'nome',
        'cargo',
        'formacao',
        'conhecimentos',
        'bio',
        'email',
        'telefone',
        'foto',
        'ordem',
        'ativo',
        'user_id'
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'ordem' => 'integer'
    ];

    // Relacionamentos
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeOrdenado($query)
    {
        return $query->orderBy('ordem');
    }

    // Accessors
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('img/default-avatar.png');
    }

    public function getNomeInicialAttribute()
    {
        $nomes = explode(' ', $this->nome);
        $iniciais = '';
        
        foreach ($nomes as $nome) {
            if (strlen($nome) > 2) { // Ignorar preposições
                $iniciais .= strtoupper(substr($nome, 0, 1));
            }
        }
        
        return $iniciais ?: strtoupper(substr($this->nome, 0, 2));
    }
}

