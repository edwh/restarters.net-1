<tr>
  {{-- EVENT DATE --}}
  <td colspan="1" width="50" class="text-center td-event-date @if($event->isInProgress()) td-event-in-progress @endif">
    <span class="td-event-day">{{ $event->getEventDate('d') }}</span>
    <br>
    <span class="td-event-month">{{ $event->getEventDate('M') }}</span>
  </td>

  {{-- EVENT LOCATION --}}
  <td colspan="1" class="cell-name">
    <a href="/party/view/{{ $event->idevents }}" class="d-block font-weight-bold">
      {{ str_limit($event->getEventName(), 20) }}
    </a>
    {{ $event->getEventDate('D j M Y') }}, {{ $event->getEventStartEnd() }}
  </td>

  {{-- ICON --}}
  <td class="table-cell-icon text-center" colspan="1">
    @php $event_group = $event->theGroup; @endphp
    @php $group_image = $event_group->groupImage; @endphp
    @if( is_object($group_image) && is_object($group_image->image) )
      <img class="mx-auto" src="{{ $group_image->image->asset_path }}" alt="{{{ $event_group->name }}}">
    @else
      <img class="mx-auto" src="{{ asset('/images/placeholder-avatar.png') }}" alt="{{{ $event_group->name }}}">
    @endif
  </td>
</tr>
