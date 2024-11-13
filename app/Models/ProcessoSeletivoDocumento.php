<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProcessoSeletivoConfiguracao;

class ProcessoSeletivoDocumento extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'descricao'];

    // public function config(){
    //     return $this->belongsTo(Config::class);
    // }
}
