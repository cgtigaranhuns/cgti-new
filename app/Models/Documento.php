<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descricao',
        'arquivo_path',
        'arquivo_nome',
        'arquivo_tipo',
        'arquivo_tamanho',
        'categoria',
        'ativo',
        'downloads',
        'user_id',
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

    public function scopeRecente($query)
    {
        return $query->orderBy('created_at', 'desc');
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

    public function getArquivoIconeAttribute()
    {
        $extensao = strtolower(pathinfo($this->arquivo_nome, PATHINFO_EXTENSION));
        
        $icones = [
            'pdf' => 'bi-file-earmark-pdf',
            'doc' => 'bi-file-earmark-word',
            'docx' => 'bi-file-earmark-word',
            'xls' => 'bi-file-earmark-excel',
            'xlsx' => 'bi-file-earmark-excel',
            'ppt' => 'bi-file-earmark-ppt',
            'pptx' => 'bi-file-earmark-ppt',
        ];
        
        return $icones[$extensao] ?? 'bi-file-earmark';
    }

    // Métodos
    public function incrementarDownload()
    {
        $this->increment('downloads');
    }

    public static function getCategorias()
    {
        return [
            'guias' => 'Guias e Manuais',
            'normas' => 'Normas e Regulamentos',
            'legislacao' => 'Legislação',
            'formularios' => 'Formulários',
            'procedimentos' => 'Procedimentos',
            'outros' => 'Outros Documentos'
        ];
    }
}

