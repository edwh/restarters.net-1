<tr>
  {{-- EVENT DATE --}}
  <td colspan="1" width="70" class="text-center td-event-date @if($event->isInProgress()) td-event-in-progress @endif">
    <span class="td-event-day">{{ $event->getEventDate('d') }}</span>
    <br>
    <span class="td-event-month">{{ $event->getEventDate('M') }}</span>
  </td>

  {{-- EVENT LOCATION --}}
  <td colspan="1" class="cell-name">
    <a href="/party/view/{{ $event->idevents }}" class="d-none d-md-block font-weight-bold">
      {{ $event->getEventName() }}
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

  {{-- PARTICPANTS --}}
  <td colspan="1" class="text-center d-none d-md-table-cell">
    {{ $event->pax }}
  </td>

  {{-- RESTARTERS --}}
  <td colspan="1" class="text-center d-none d-md-table-cell">
    {{ $event->checkForMissingData()['volunteers_count'] }}
  </td>

  @php( $stats = $event->getEventStats($EmissionRatio) )

  {{-- WASTE PREVENTED --}}
  <td colspan="1" class="text-center">
    {{ number_format(round($stats['ewaste']), 0) }}
  </td>

  {{-- CO2 EMISSIONS PREVENTED --}}
  <td colspan="1" class="text-center">
    {{ number_format(round($stats['co2']), 0) }}
  </td>

  {{-- FIXED DEVICES --}}
  <td colspan="1" class="text-center d-none d-md-table-cell">
    {{ $stats['fixed_devices'] }}
  </td>

  {{-- REPAIRABLE DEVICES --}}
  <td colspan="1" class="text-center d-none d-md-table-cell">
    {{ $stats['repairable_devices'] }}
  </td>

  {{-- DEAD DEVICES --}}
  <td colspan="1" class="text-center d-none d-md-table-cell">
    {{ $stats['dead_devices'] }}
  </td>
</tr>
