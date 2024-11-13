<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ProcessoSeletivoInscricao;

class ProcessoSeletivoAnalise extends Model
{
    use HasFactory;
    protected $fillable = ['id_inscricao', 'status', 'mensagem', 'analisado_por'];

    /**
     * Get the inscricao that owns the ProcessoSeletivoAnalise
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inscricao()
    {
        return $this->belongsTo(ProcessoSeletivoInscricao::class, 'id_inscricao');
    }
}
