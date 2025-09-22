@if ($paginator->hasPages())
    <div class="pagination-section">
        <nav class="overflow-auto">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item"><a href="javascript:void(0);" class="page-link disabled-link"><i
                                class="fa-regular fa-angle-left"></i></a></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}"><i
                                class="fa-regular fa-angle-left"></i></a></li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0);">{{ $element }}</a>
                        </li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active">
                                    <a class="page-link" href="#">{{ $page }}<span class="sr-only">(current)</span></a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url}}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}"><i
                                class="fa-regular fa-angle-right"></i></a></li>
                @else
                    <li class="page-item"><a href="javascript:void(0);" class="page-link disabled-link"><i
                                class="fa-regular fa-angle-right"></i></a></li>
                @endif
            </ul>
        </nav>
    </div>
@endif
