<section class="table-section py-30" id="all-events">
  <p class="mb-30">
    There are <span class="font-weight-bold">{{ $all_events_count }} events</span>. See <a href="{{ route('all-past-events') }}" class="btn-link">past events</a>
  </p>

  @include('group.group-filters')

  <div class="table-responsive">
    <table role="table" class="table table-striped table-hover" id="sort-table">
      @include('partials.tables.head-events')

      <tbody>
        @if( ! $all_events->isEmpty() )
          @foreach($all_events as $event)
            @include('partials.tables.row-events')
          @endforeach
        @else
          <tr>
            <td colspan="13" align="center" class="p-3">There are currently no past events for this group</td>
          </tr>
        @endif

        {{-- @if( ! $past_events->isEmpty() )
          @foreach($past_events as $event)
            @include('partials.tables.row-events', ['show_invites_count' => false, 'EmissionRatio' => $EmissionRatio])
          @endforeach
        @else
          <tr>
            <td colspan="13" align="center" class="p-3">There are currently no past events for this group</td>
          </tr>
        @endif --}}
      </tbody>
    </table>
  </div>

  <div class="d-flex justify-content-center">
    <nav aria-label="Page navigation example">
      {{-- Custom pagination view --}}
      <ul class="pagination">
        @include('pagination', [
          'paginator' => $all_events->appends(request()->input()),
          'onEachSide' => 4
        ])
      </ul>
    </nav>
  </div>
</section>
