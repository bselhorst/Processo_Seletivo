@props(['header_description', 'name', 'multiple', 'required'])
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> {{ @$header_description }} <code>(PDF)</code> 
            @if (@$required)
                <span class="badge bg-danger bg-opacity-20 text-danger">Obrigatório</span>
            @endif
            @if (@$multiple)
                <span class="badge bg-info bg-opacity-20 text-info">Aceita vários arquivos</span>
            @endif
        </h5>
    </div>
    <div class="card-body">
        <p class="fw-semibold">Pré visualização</p>
        <input type="file" name="{{@$name}}[]" class="{{ $required == "1" ? 'file-input-required' : 'file-input' }}" {{ $multiple == "1" ? 'multiple' : '' }}
            accept=".pdf">
    </div>
</div>
