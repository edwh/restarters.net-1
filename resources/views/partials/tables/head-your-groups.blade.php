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
