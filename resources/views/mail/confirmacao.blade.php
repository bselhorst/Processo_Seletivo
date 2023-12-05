{{-- Bem vindo ao curso {{ $name }} --}}
{{-- <link href="{{ asset('assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css"> --}}
	{{-- <link href="{{ asset('assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css"> --}}
{{-- <link href="{{ asset('assets/css/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css"> --}}

<div style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
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
    
    {{-- {{ App\Models\ProcessoSeletivoCurso::findOrFail($data["id_processo_seletivo_curso"]) }}
    {{ $data["id_processo_seletivo_curso"] }}
    {{ dd($data) }} --}}
    {{-- {{ dd(get_defined_vars()) }} --}}
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
</div>