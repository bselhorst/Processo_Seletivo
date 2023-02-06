<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProcessoSeletivoInscricao;

class ProcessoSeletivoInscricaoNota extends Model
{
    use HasFactory;

    protected $fillable = ['id_inscricao', 'status', 'nota_titulacao', 'nota_qualificacao', 'nota_exp_profissional', 'mensagem'];

    // public function tipo_documento(){
    //     return $this->belongsTo(ProcessoSeletivoInscricao::class, 'id_inscricao');
    // }

    public function inscricao(){
        return $this->belongsTo(ProcessoSeletivoInscricao::class, 'id_inscricao');
    }
}
