<ul class="uk-pagination">
    <li>
        <a href="{{ $paginator->url(1)}}">
            <i class="uk-icon-angle-double-left"></i>
        </a>
    </li>
    @for ($i = 1; $i <= $paginator->lastPage(); $i++)
        @if ($paginator->currentPage() == $i)
            <li class="uk-active"><span>{{ $i }}</span></li>
        @else
            <li><a href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
        @endif
    @endfor
    <li>
        <a href="{{ $paginator->url($paginator->lastPage()) }}">
            <i class="uk-icon-angle-double-right"></i>
        </a>
    </li>
</ul>