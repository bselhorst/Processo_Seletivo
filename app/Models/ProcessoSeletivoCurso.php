<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AuxiliarMunicipio;
use App\Models\ProcessoSeletivo;
use App\Models\ProcessoSeletivoInscricao;

class ProcessoSeletivoCurso extends Model
{
    use HasFactory;
    protected $fillable = ['id_processo_seletivo', 'id_municipio', 'titulo', 'descricao', 'salario', 'carga_horaria', 'vagas']; 
    
    public function municipio(){
        return $this->belongsTo(AuxiliarMunicipio::class, 'id_municipio');
    }

    public function processo_seletivo(){
        return $this->belongsTo(ProcessoSeletivo::class, 'id_processo_seletivo');
    }

    public function inscricoes(){
        return $this->hasMany(ProcessoSeletivoInscricao::class, 'id_processo_seletivo_curso', 'id');
    }
}
