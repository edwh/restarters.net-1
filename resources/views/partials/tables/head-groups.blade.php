<thead>
  <tr>
    {{-- ICON --}}
    <th width="42">
    </th>

    {{-- NAME --}}
    <th width="200" scope="col">
    </th>

    {{-- TODO --}}
    {{-- LOCATION --}}
    <th scope="col">
      <label for="label-upcoming_event" class="sort-column justify-content-center">
        @include('svgs/fixometer/location-pin')
      </label>
    </th>

    {{-- TODO --}}
    {{-- USER --}}
    <th scope="col" class="text-center">
      <label for="label-upcoming_event" class="sort-column justify-content-center">
        @include('svgs/navigation/user-icon')
      </label>
    </th>

    {{-- PARTCIPANTS --}}
    <th scope="col" class="text-center">
      <label for="label-upcoming_event" class="sort-column justify-content-center @if( $sort_column == 'upcoming_event' ) sort-column-{{{ strtolower($sort_direction) }}} @endif">
        @include('svgs/navigation/groups-icon')
      </label>
    </th>

    {{-- NEXT EVENT DATE --}}
    <th scope="col" class="text-center">
      <label for="label-partcipants" class="sort-column justify-content-center @if( $sort_column == 'partcipants' ) sort-column-{{{ strtolower($sort_direction) }}} @endif">
        @include('svgs/navigation/events-icon')
      </label>
    </th>

    {{-- FOLLOW BUTTON --}}
    <th scope="col" class="text-center">
      &nbsp;
    </th>
  </tr>
</thead>

{{-- <thead>
  <tr>
    <th width="42">
    </th>

    <th width="140" scope="col">
      <label for="label-name"  class="sort-column @if( $sort_column == 'name' ) sort-column-{{{ strtolower($sort_direction) }}} @endif">
        @lang('groups.groups_name')
      </label>
    </th>

    <th width="140" scope="col">
      <label for="label-location" class="sort-column @if( $sort_column == 'distance' ) sort-column-{{{ strtolower($sort_direction) }}} @endif">
        @lang('groups.groups_location')
      </label>
    </th>

    <th width="70" scope="col" class="text-center">
      <label for="label-hosts" class="sort-column @if( $sort_column == 'hosts' ) sort-column-{{{ strtolower($sort_direction) }}} @endif">
        @lang('groups.groups_hosts')
      </label>
    </th>

    <th width="80" scope="col" class="text-center">
      <label for="label-restarters" class="sort-column @if( $sort_column == 'restarters' ) sort-column-{{{ strtolower($sort_direction) }}} @endif">
        @lang('groups.groups_restarters')
      </label>
    </th>

    <th width="100" scope="col" class="text-center">
      <label for="label-upcoming_event" class="sort-column @if( $sort_column == 'upcoming_event' ) sort-column-{{{ strtolower($sort_direction) }}} @endif">
        @lang('groups.groups_upcoming_event')
      </label>
    </th>

    @if( FixometerHelper::hasRole(Auth::user(), 'Administrator'))
      <th width="75" scope="col" class="text-center">
        <label for="label-created" class="sort-column @if( $sort_column == 'created_at' ) sort-column-{{{ strtolower($sort_direction) }}} @endif">
          {{ __('Created At') }}
        </label>
      </th>
    @endif
  </tr>
</thead> --}}
