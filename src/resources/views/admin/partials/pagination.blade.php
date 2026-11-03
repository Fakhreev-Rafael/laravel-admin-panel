<!-- 
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active" aria-current="page"><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav> -->


@if ($paginator->hasPages())
<ul class="pagination">
    @if ($paginator->onFirstPage())
    <li class="pagination__element pagination__previous">
        <x-admin.icons.arrow-down class="icon icon--primary icon--m" />
    </li>
    @else
    <li class="pagination__element pagination__previous">
        <a class="pagination__link" href="{{ $paginator->previousPageUrl() }}">
            <x-admin.icons.arrow-down class="icon icon--primary icon--m" />
        </a>
    </li>
    @endif

    @foreach ($elements as $element)
    {{-- "Three Dots" Separator --}}
    @if (is_string($element))
    <li class="pagination__element">
        {{ $page }}
    </li>
    @endif

    @if (is_array($element))
    @foreach ($element as $page => $url)
    @if ($page == $paginator->currentPage())
    <li class="pagination__element pagination__current">
        {{ $page }}
    </li>
    @else
    <li class="pagination__element">
        <a class="pagination__link" href="{{ $url }}">
            {{ $page }}
        </a>
    </li>
    @endif
    @endforeach
    @endif
    @endforeach

    @if ($paginator->hasMorePages())
    <li class="pagination__element pagination__next">
        <a class="pagination__link" href="{{ $paginator->nextPageUrl() }}">
            <x-admin.icons.arrow-down class="icon icon--primary icon--m" />
        </a>
    </li>
    @else
    <li class="pagination__element pagination__next">
        <x-admin.icons.arrow-down class="icon icon--primary icon--m" />
    </li>
    @endif
</ul>
@endif