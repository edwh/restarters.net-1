<tr>
  {{-- ICON --}}
  <td class="table-cell-icon text-center" colspan="1">
    @php( $group_image = $group->groupImage )
    @if( is_object($group_image) && is_object($group_image->image) )
      <img class="mx-auto" src="{{ asset('/uploads/thumbnail_' . $group_image->image->path) }}" alt="{{{ $group->name }}}">
    @else
      <img class="mx-auto" src="{{ asset('/images/placeholder-avatar.png') }}" alt="{{{ $group->name }}}">
    @endif
  </td>

  {{-- NAME --}}
  <td colspan="1">
    <a href="/group/view/{{{ $group->idgroups }}}" title="edit group">
      {{{ $group->name }}}
    </a>
  </td>

  {{-- LOCATION --}}
  <td class="text-center d-none d-md-table-cell" colspan="1">
    {{{ $group->getLocation() }}}
  </td>

  {{-- NEXT EVENT DATE --}}
  @php ($next_upcoming_event = $group->getNextUpcomingEvent())
  <td class="text-center d-none d-md-table-cell" colspan="1">
    @if ( is_null($next_upcoming_event) )
      <p>@lang('groups.upcoming_none_planned')</p>
    @else
      <a href="/party/view/{{ $next_upcoming_event->idevents }}">
        <div>{{ $next_upcoming_event->getEventDate('D jS M Y') }}</div>
      </a>
    @endif
  </td>

  {{-- FOLLOW BUTTON --}}
  {{-- TODO: Link/route for unfollowing to be confirmed. --}}
  <td class="text-center" colspan="1">
    <a class="btn btn-primary" href="/group/join/{{ $group->idgroups }}" id="join-group">
      Unfollow
    </a>
  </td>
</tr>
