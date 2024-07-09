<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ProcessoSeletivoInscricao;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProcessoSeletivoInscricaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = ProcessoSeletivoInscricao::class;

    public function definition()
    {
        return [
            'id_processo_seletivo_curso' => 3,
            'id_tipo_documento' => 1,
            'numero_documento' => "99999999",
            'nome' => fake()->name(),
            'endereco' => Str::random(25),
            'bairro' => Str::random(10),
            'numero_contato' => "68999999999",
            'email' => fake()->unique()->safeEmail(),
            'data_nascimento' => now(),
            'deficiencia' => 2,
        ];
    }
}
