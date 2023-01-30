<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessoSeletivoInscricao extends Model
{
    use HasFactory;
    protected $fillable = ['id_processo_seletivo_curso', 'id_tipo_documento', 'numero_documento', 'nome', 'endereco', 'bairro', 'numero_contato', 'email'];
}
