<div class="pagination-product">
    @if ($data->lastPage() > 1)
        <ul class="pagination-list">
            {{-- Previous Page Link --}}
            @if ($data->onFirstPage())
                <li class="disabled"><span>&laquo;</span></li>
                <li class="disabled"><span>&#8249;</span></li>
            @else
                <li><a href="{{ $data->url(1) }}" rel="prev">&laquo;</a></li>
                <li><a href="{{ $data->previousPageUrl() }}" rel="prev">&#8249;</a></li>
            @endif

            {{-- Pagination Elements --}}

            @for ($i = 1; $i <= $data->lastPage(); $i++)
                @if ($i == $data->currentPage())
                    <li class="active"><span>{{ $i }}</span></li>
                @elseif ($i >= $data->currentPage() - 2 && $i <= $data->currentPage() + 2)
                    <li><a href="{{ $data->url($i) }}">{{ $i }}</a></li>
                @elseif ($i == $data->currentPage() - 3 || $i == $data->currentPage() + 3)
                    <li class="disabled"><span>&hellip;</span></li>
                @endif
            @endfor
            {{-- Next Page Link --}}
            @if ($data->hasMorePages())
                <li><a href="{{ $data->nextPageUrl() }}" rel="next">&#8250;</a></li>
                <li><a href="{{ $data->url($data->lastPage()) }}" rel="next">&raquo;</a></li>
            @else
                <li class="disabled"><span>&#8250;</span></li>
                <li class="disabled"><span>&raquo;</span></li>
            @endif

        </ul>
    @endif
</div>
