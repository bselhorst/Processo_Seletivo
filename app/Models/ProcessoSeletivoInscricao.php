<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProcessoSeletivoInscricaoNota;
use App\Models\AuxiliarTipoDocumento;

class ProcessoSeletivoInscricao extends Model
{
    use HasFactory;
    protected $fillable = ['id_processo_seletivo_curso', 'id_tipo_documento', 'numero_documento', 'nome', 'endereco', 'bairro', 'numero_contato', 'email'];

    public function curso(){
        return $this->belongsTo(ProcessoSeletivoCurso::class, 'id_processo_seletivo_curso');
    }

    public function tipo_documento(){
        return $this->belongsTo(AuxiliarTipoDocumento::class, 'id_tipo_documento');
    }

    public function notas(){
        return $this->hasOne(ProcessoSeletivoInscricaoNota::class, 'id_inscricao');
    }
}
