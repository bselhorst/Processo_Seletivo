<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProcessoSeletivoCurso;

class ProcessoSeletivo extends Model
{
    use HasFactory;
    protected $fillable = ['titulo', 'descricao', 'data_abertura', 'data_encerramento'];

    public function cursos(){
        return $this->hasMany(ProcessoSeletivoCurso::class, 'id_processo_seletivo', 'id');
    }
}
