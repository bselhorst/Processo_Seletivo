<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AuxiliarMunicipio;

class ProcessoSeletivoCurso extends Model
{
    use HasFactory;
    protected $fillable = ['id_processo_seletivo', 'id_municipio', 'titulo', 'descricao', 'salario', 'carga_horaria', 'vagas'];   

}
