<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessoSeletivoComunicado extends Model
{
    use HasFactory;
    protected $fillable = ['id_processo_seletivo', 'titulo', 'documento']; 
}
