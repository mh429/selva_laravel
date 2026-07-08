@if ($paginator->hasPages())

    <nav class="pager_nav">

        {{-- 前へ --}}
        @if ($paginator->onFirstPage())
            <span class="pager_dummy"></span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="pager_prev_back">前へ＞</a>
        @endif

        @php
            $current = $paginator->currentPage();
            $last = $paginator->lastPage();

            if ($current <= 2) {
                $start = 1;
            } elseif ($current >= $last - 1) {
                $start = max($last - 2, 1);
            } else {
                $start = $current - 1;
            }

            $end = min($start + 2, $last);
        @endphp

        {{-- ページ番号 --}}
        <div class="pager_pages">
          @for ($page = $start; $page <= $end; $page++)
              @if ($page == $current)
                  <span class="pager_selected">{{ $page }}</span>
              @else
                  <a href="{{ $paginator->url($page) }}" class="pager_page">{{ $page }}</a>
              @endif
          @endfor
        </div>

        {{-- 次へ --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="pager_prev_back">次へ＞</a>
        @else
            <span class="pager_dummy"></span>
        @endif

    </nav>

@endif