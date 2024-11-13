<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProcessoSeletivoDocumento;

class ProcessoSeletivoConfiguracao extends Model
{
    use HasFactory;
    protected $fillable = ['id_processo_seletivo', 'id_processo_seletivo_doc', 'obrigatorio', 'pontuacao', 'multiplos_arquivos'];

    public function documento(){
        return $this->hasOne(ProcessoSeletivoDocumento::class, 'id', 'id_processo_seletivo_doc');
    }
}
