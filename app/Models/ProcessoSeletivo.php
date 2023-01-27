<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessoSeletivo extends Model
{
    use HasFactory;
    protected $fillable = ['titulo', 'descricao', 'data_abertura', 'data_encerramento'];
}
