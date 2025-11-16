@if ($paginator->hasPages())
    <nav class="d-flex justify-content-between">
        <ul class="pagination pagination-rounded pagination-simple">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">
                        <i class="bi bi-chevron-left"></i> Anterior
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <i class="bi bi-chevron-left"></i> Anterior
                    </a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        Siguiente <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">
                        Siguiente <i class="bi bi-chevron-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>

    <style>
        .pagination-simple .page-item .page-link {
            border: none;
            background: none;
            color: #1e3c72;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            transition: all 0.2s;
        }

        .pagination-simple .page-item .page-link:hover {
            background-color: rgba(30, 60, 114, 0.1);
        }

        .pagination-simple .page-item.disabled .page-link {
            color: #6c757d;
            background-color: transparent;
            pointer-events: none;
        }
    </style>
@endif