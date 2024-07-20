@if ($paginator->hasPages())
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center mt-5">
            @if ($paginator->onFirstPage())
                <li class="page-item">
                    <a class="page-link new-near-you-button disabled" tabindex="-1">
                        Prev Page
                    </a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link new-near-you-button" dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" wire:click.prevent="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" href="#">
                        Prev Page
                    </a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled">{{ $element }}</li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <a class="page-link" disabled aria-current="page">{{ $page }}</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}" wire:click.prevent="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" href="#">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link new-near-you-button" dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" wire:click.prevent="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" href="#" rel="next">Next Page</a>
                </li>
            @else
                <li class="page-item ">
                    <a class="page-link new-near-you-button disabled" >Next Page</a>
                </li>
            @endif
        </ul>
    </nav>
@endif
