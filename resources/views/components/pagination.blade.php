@props(['data'])

<div class="d-flex align-items-center" style="margin-left: 20px; margin-right: 20px; margin-bottom: 20px">
    <span class="text-muted me-auto">Mostrando {{ $data->firstItem() }} até {{ $data->lastItem() }} de {{ $data->total() }} registros</span>
    <span class="text-muted me-3">{{ $data->currentPage() }} de {{ $data->lastPage() }}</span>
    <ul class="pagination pagination-flat">
        <li class="page-item {{ ($data->currentPage() > 1) ? '' : 'disabled' }}">
            <a href="{{ $data->previousPageUrl()."&"."pesquisa=".$search }}" class="page-link rounded">←</a>
        </li>
        @if ($data->currentPage() > 4)
            <li class="page-item">
                <a href="{{ $data->url(1)."&"."pesquisa=".$search }}" class="page-link rounded">1</a>
            </li>
            <li class="page-item">
                <a href="#" class="page-link rounded">...</a>
            </li>                   
        @endif
        @if ($data->currentPage() >= 3)
            @for ($i = $data->currentPage()-2; $i <= $data->currentPage(); $i++)
                @if ($i == $data->currentPage())
                    <li class="page-item active">
                        <a href="{{ $data->url($i)."&"."pesquisa=".$search }}" class="page-link rounded">{{ $i }}</a>
                    </li>
                @else
                    <li class="page-item">
                        <a href="{{ $data->url($i)."&"."pesquisa=".$search }}" class="page-link rounded">{{ $i }}</a>
                    </li>
                @endif                    
            @endfor
        @else
            @for ($i = 1; $i <= $data->currentPage(); $i++)
                @if ($i == $data->currentPage())
                    <li class="page-item active">
                        <a href="{{ $data->url($i)."&"."pesquisa=".$search }}" class="page-link rounded">{{ $i }}</a>
                    </li>
                @else
                    <li class="page-item">
                        <a href="{{ $data->url($i)."&"."pesquisa=".$search }}" class="page-link rounded">{{ $i }}</a>
                    </li>
                @endif                    
            @endfor
        @endif
        @if ($data->lastPage()-$data->currentPage() < 3)
            @for ($i = $data->currentPage()+1; $i <= $data->lastPage(); $i++)
                <li class="page-item">
                    <a href="{{ $data->url($i)."&"."pesquisa=".$search }}" class="page-link rounded">{{ $i }}</a>
                </li>                   
            @endfor
        @else
            @for ($i = $data->currentPage()+1; $i <= $data->currentPage()+2; $i++)
                <li class="page-item">
                    <a href="{{ $data->url($i)."&"."pesquisa=".$search }}" class="page-link rounded">{{ $i }}</a>
                </li>              
            @endfor
        @endif
        @if ($data->lastPage()-$data->currentPage() >= 4)
            <li class="page-item">
                <a href="#" class="page-link rounded">...</a>
            </li>
            <li class="page-item">
                <a href="{{ $data->url($data->lastPage())."&"."pesquisa=".$search }}" class="page-link rounded">{{ $data->lastPage() }}</a>
            </li>                   
        @endif
        <li class="page-item {{ ($data->hasMorePages()) ? '' : 'disabled' }}">
            <a href="{{ $data->nextPageUrl()."&"."pesquisa=".$search }}" class="page-link rounded">→</a>
        </li>
    </ul>
</div>