<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessoSeletivoCurso extends Model
{
    use HasFactory;
    protected $fillable = ['id_processo_seletivo', 'municipio', 'titulo', 'descricao', 'salario', 'vagas'];
}
