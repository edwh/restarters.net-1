<tr>
  {{-- ICON --}}
  <td class="table-cell-icon" colspan="1">
    @php( $group_image = $group->groupImage )
    @if( is_object($group_image) && is_object($group_image->image) )
      <img src="{{ asset('/uploads/thumbnail_' . $group_image->image->path) }}" alt="{{{ $group->name }}}">
    @else
      <img src="{{ asset('/images/placeholder-avatar.png') }}" alt="{{{ $group->name }}}">
    @endif
  </td>

  {{-- NAME --}}
  <td colspan="1">
    <a href="/group/view/{{{ $group->idgroups }}}" title="edit group">
      {{{ $group->name }}}
    </a>
  </td>

  {{-- LOCATION --}}
  <td colspan="1">
    {{{ $group->getLocation() }}}
  </td>

  <td colspan="1">

  </td>

  <td colspan="1">

  </td>

  {{-- NEXT EVENT DATE --}}
  @php ($next_upcoming_event = $group->getNextUpcomingEvent())
  <td class="text-center">
    @if ( is_null($next_upcoming_event) )
      <p>@lang('groups.upcoming_none_planned')</p>
    @else
      <a href="/party/view/{{ $next_upcoming_event->idevents }}">
        <div>{{ $next_upcoming_event->getEventDate('D jS M Y') }}</div>
      </a>
    @endif
  </td>

  {{-- FOLLOW BUTTON --}}
  <td class="text-center" colspan="1">
    @if ( ! in_array($group->idgroups, $your_groups_uniques) )
      <a class="btn btn-primary" href="/group/join/{{ $group->idgroups }}" id="join-group">
        Follow
      </a>
    @endif
  </td>
</tr>
