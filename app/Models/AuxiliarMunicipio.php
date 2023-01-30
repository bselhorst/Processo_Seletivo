<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProcessoSeletivoCurso;

class AuxiliarMunicipio extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'descricao'];

    public function municipio(){
        return $this->hasMany(ProcessoSeletivoCurso::class, 'id_municipio');
    }

}
