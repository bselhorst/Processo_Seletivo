@php
    $processos = \App\Models\ProcessoSeletivo::all();                
@endphp

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processos Seletivos - Inscrição</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 50px 0;
        }

        h1 {
            font-size: 36px;
            font-weight: 500;
            text-align: center;
            color: #4CAF50;
            margin-bottom: 50px;
        }

        .processos {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
        }

        .processo-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .processo-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .processo-header {
            position: relative;
            height: 200px;
            background-color: #4CAF50;
            background-image: url('https://via.placeholder.com/1200x400');
            background-size: cover;
            background-position: center;
            border-radius: 8px 8px 0 0;
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
            padding: 20px;
        }

        .processo-header h2 {
            font-size: 14px;
            color: #fff;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .processo-info {
            padding: 20px;
        }

        .processo-info p {
            font-size: 16px;
            color: #666;
            margin-bottom: 10px;
        }

        .horarios {
            font-size: 14px;
            color: #777;
        }

        .horarios span {
            font-weight: bold;
        }

        .btn-inscricao {
            display: inline-block;
            background-color: #4CAF50;
            color: #fff;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
            width: 100%;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .btn-inscricao:hover {
            background-color: #45a049;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .processo-header h2 {
                font-size: 22px;
            }

            .processo-info p {
                font-size: 14px;
            }

            .horarios {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Processos Seletivos e Inscrições</h1>

        <div class="processos">
            @foreach ($processos as $processo)
                <div class="processo-card">
                    <div class="processo-header">
                        <h2>{{ $processo->titulo }}</h2>
                    </div>
                    <div class="processo-info">
                        <p>{{ $processo->descricao }}</p>
                        <div class="horarios">
                            <p><span>Início:</span> {{ \Carbon\Carbon::parse($processo->inicio)->format('d/m/Y H:i') }}</p>
                            <p><span>Término:</span> {{ \Carbon\Carbon::parse($processo->fim)->format('d/m/Y H:i') }}</p>
                        </div>
                        {{-- <a href="{{ route('inscricao.show', $processo->id) }}" class="btn-inscricao">Inscreva-se</a> --}}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</body>
</html>


