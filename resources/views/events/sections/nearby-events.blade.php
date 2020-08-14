<section class="table-section py-30" id="nearby-events">
  <div class="table-responsive">
    <table role="table" class="table table-striped table-hover">
      @include('partials.tables.head-events')
      <tbody>
        @if ( is_null(auth()->user()->latitude) && is_null(auth()->user()->longitude) )
          <tr>
            <td colspan="13" align="center" class="p-3">
              Your town/city has not been set.
              <br>
              <a href="{{{ route('edit-profile', ['id' => auth()->id()]) }}}">
                Click here to set it and find events near you.
              </a>
            </td>
          </tr>
        @elseif( ! $upcoming_events_in_area->isEmpty() )
          @foreach($upcoming_events_in_area as $event)
            @include('partials.tables.row-events')
          @endforeach
        @else
          <tr>
            <td colspan="13" align="center" class="p-3">
              @lang('events.no_upcoming_near_you', ['resources_link' => env('DISCOURSE_URL' ).'/session/sso?return_path='.env('DISCOURSE_URL').'/t/how-to-power-up-community-repair-with-restarters-net/1228/'])
            </td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>
</section>
