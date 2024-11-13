<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProcessoSeletivoAnalise;

class ProcessoSeletivoNota extends Model
{
    use HasFactory;
    protected $fillable = ['id_processo_seletivo_analise', 'id_processo_seletivo_doc', 'nota'];
    
    /**
     * Get the user that owns the ProcessoSeletivoNota
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(ProcessoSeletivoAnalise::class);
    }
}
