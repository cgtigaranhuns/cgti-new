<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Processo extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descricao',
        'categoria',
        'arquivo_path',
        'arquivo_nome',
        'arquivo_tamanho',
        'arquivo_tipo',
        'ativo',
        'downloads',
        'user_id'
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'downloads' => 'integer',
        'arquivo_tamanho' => 'integer'
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

    public function scopeCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    // Accessors
    public function getArquivoTamanhoFormatadoAttribute()
    {
        if (!$this->arquivo_tamanho) {
            return 'N/A';
        }

        $bytes = $this->arquivo_tamanho;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getArquivoUrlAttribute()
    {
        if ($this->arquivo_path) {
            return asset('storage/' . $this->arquivo_path);
        }
        return null;
    }

    // Métodos
    public function incrementarDownload()
    {
        $this->increment('downloads');
    }

    public static function getCategorias()
    {
        return [
            'cgti' => 'CGTI - Coordenação de Gestão de TI',
            'cgpe' => 'CGPE - Coordenação de Gestão de Pessoas',
            'aspe' => 'ASPE - Assessoria de Planejamento',
            'ccli' => 'CCLI - Coordenação de Compras e Licitações',
            'crat' => 'CRAT - Coordenação de Registro Acadêmico',
            'cpgd' => 'CPGD - Coordenação de Pós-Graduação',
            'ctra' => 'CTRA - Coordenação de Transporte',
            'den' => 'DEN - Diretoria de Ensino'
        ];
    }
}

