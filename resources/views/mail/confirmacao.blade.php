{{-- Bem vindo ao curso {{ $name }} --}}
{{-- <link href="{{ asset('assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css"> --}}
	{{-- <link href="{{ asset('assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css"> --}}
{{-- <link href="{{ asset('assets/css/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css"> --}}

{{-- <div style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  margin: 0 auto;
  transition: 0.3s;
  padding-left: 20px;
  padding-right: 20px;
  width: 800px;
  text-align: center;
  font-family: sans-serif;
  padding-top: 20px; 
  padding-bottom: 20px;
  border: 1px solid; 
  border-radius: 4px;
  left: 50%">
    <img height="120px" src="{{ URL::asset('https://ieptec.ac.gov.br/wp-content/uploads/2023/08/IEPTEC-2023.fw_.png') }}" alt="">
    <div style="font-size: 36px; padding-top: 30px; padding-bottom: 30px">
        Confirmação de Inscrição   
    </div>
    
    <div style="width: 100%">
        <table style="font-size: 18px" class="table">
            <tbody>
            <tr>
                <td style="text-align: left"><b>Município: </b></td>
                <td style="text-align: left">{{ App\Models\AuxiliarMunicipio::findOrFail(App\Models\ProcessoSeletivoCurso::findOrFail($data["id_processo_seletivo_curso"])->id_municipio)->nome }}</td>
            </tr>
            <tr>
                <td style="text-align: left"><b>Área: </b></td>
                <td style="text-align: left">{{ App\Models\ProcessoSeletivoCurso::findOrFail($data["id_processo_seletivo_curso"])->titulo }}</td>
            </tr>
            <tr>
                <td style="text-align: left"><b>Nome Completo: </b></td>
                <td style="text-align: left">{{ $data["nome"] }} </td>
            </tr>
            <tr>
                <td style="text-align: left"><b>Tipo de Documento: </b></td>
                <td style="text-align: left">{{ App\Models\AuxiliarTipoDocumento::findOrFail($data["id_tipo_documento"])->nome }}</td>
            </tr>
            <tr>
                <td style="text-align: left"><b>Número do Documento: </b></td>
                <td style="text-align: left">{{ $data["numero_documento"] }}</td>
            </tr>
            <tr>
                <td style="text-align: left"><b>Contato: </b></td>
                <td style="text-align: left">{{ $data["numero_contato"] }}</td>
            </tr>
            <tr>
                <td style="text-align: left"><b>Email: </b></td>
                <td style="text-align: left">{{ $data["email"] }}</td>
            </tr>
        </tbody></table>   
    </div>
</div> --}}

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Inscrição</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #4CAF50;
            font-size: 24px;
            text-align: center;
        }

        p {
            color: #555;
            font-size: 16px;
            line-height: 1.6;
            text-align: center;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 250px; /* Ajuste o tamanho da logo conforme necessário */
            height: auto;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .details-table th,
        .details-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .details-table th {
            background-color: #f4f4f4;
            color: #333;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            margin-top: 20px;
        }

        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }

        .btn {
            display: inline-block;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            margin-top: 20px;
            text-align: center;
        }

        /* Responsividade */
        @media (max-width: 600px) {
            .email-container {
                padding: 15px;
            }

            h1 {
                font-size: 20px;
            }

            p {
                font-size: 14px;
                text-align: center;
            }

            .details-table th,
            .details-table td {
                font-size: 14px;
                padding: 6px;
            }

            .btn {
                padding: 12px 24px;
                width: 100%;
                text-align: center;
            }

            .footer {
                font-size: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Logo do local -->
        <div class="logo">
            <img src="{{ URL::asset('https://ieptec.ac.gov.br/wp-content/uploads/2023/08/IEPTEC-2023.fw_.png') }}" alt="Logo do Local">
        </div>

        <h1>Confirmação de Inscrição</h1>
        <p>Olá, {{ explode(" ", $data["nome"])[0] }}!</p>
        <p>Obrigado por se inscrever! Abaixo estão os detalhes da sua inscrição:</p>

        <table class="details-table">
            <tr>
                <th>Nome Completo</th>
                <td>{{ $data["nome"] }}</td>
            </tr>
            <tr>
                <th>Município</th>
                <td>{{ App\Models\AuxiliarMunicipio::findOrFail(App\Models\ProcessoSeletivoCurso::findOrFail($data["id_processo_seletivo_curso"])->id_municipio)->nome }}</td>
            </tr>
            <tr>
                <th>Área</th>
                <td>{{ App\Models\ProcessoSeletivoCurso::findOrFail($data["id_processo_seletivo_curso"])->titulo }}</td>
            </tr>
            <tr>
                <th>Documento</th>
                <td>{{ App\Models\AuxiliarTipoDocumento::findOrFail($data["id_tipo_documento"])->nome }} {{ $data["numero_documento"] }}</td>
            </tr>
            <tr>
                <th>Contato</th>
                <td>{{ $data["numero_contato"] }}</td>
            </tr>
            <tr>
                <th>E-mail</th>
                <td>{{ $data["email"] }}</td>
            </tr>
        </table>

        <div class="footer">
            <p>Este é um e-mail automático. Por favor, não responda.</p>
            <p>Visite nosso site para mais informações: <a href="https://processoseletivo.ieptec.ac.gov.br">IEPTEC</a></p>
        </div>
    </div>
</body>
</html>
