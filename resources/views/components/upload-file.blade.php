@props(['header_description', 'name', 'multiple' => false, 'required' => false])
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"> {{ @$header_description }} <code>(PDF)</code>
        </h5>
    </div>
    <div class="card-body">
        <p class="fw-semibold">Pré visualização</p>
        <input type="file" name="anexo_{{@$name}}[]" class="{{ $required ? 'file-input-required' : 'file-input' }}" {{ $multiple ? 'multiple' : '' }}
            accept=".pdf">
    </div>
</div>