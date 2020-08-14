@if (isset($paginator) && $paginator->lastPage() > 1)
  <ul class="pagination mt-0" role="navigation">
    @php
    $onEachSide = isset($onEachSide) ? abs(intval($onEachSide)) : 3 ;
    $from = $paginator->currentPage() - $onEachSide;
    if($from < 1) {
      $from = 1;
    }

    $to = $paginator->currentPage() + $onEachSide;
    if($to > $paginator->lastPage()) {
      $to = $paginator->lastPage();
    }
    @endphp

    <!-- first/previous -->
    @if($paginator->currentPage() > 1)
      <li class="page-item">
        <a class="page-link" href="{{ $paginator->url($paginator->currentPage() - 1) }}" rel="prev" aria-label="« Previous">
          ‹
        </a>
      </li>
    @endif

    <!-- links -->
    @for($i = $from; $i <= $to; $i++)
      @php $isCurrentPage = $paginator->currentPage() == $i; @endphp
      <li class="page-item {{ $isCurrentPage ? 'active' : '' }}" aria-current="page">
        @if ($isCurrentPage)
          <span class="page-link">
            {{ $i }}
          </span>
        @else
          <a class="page-link" href="{{ $paginator->url($i) }}">
            {{ $i }}
          </a>
        @endif
      </li>
    @endfor

    <!-- next/last -->
    @if($paginator->currentPage() < $paginator->lastPage())
      <li class="page-item">
        <a class="page-link" href="{{ $paginator->url($paginator->currentPage() + 1) }}" rel="next" aria-label="Next »">
          ›
        </a>
      </li>
    @endif
  </ul>
@endif
