<thead>
  <tr>
    {{-- EVENT DATE --}}
    <th scope="col" width="70">
      &nbsp;
    </th>

    {{-- EVENT LOCATION --}}
    <th scope="col">
      &nbsp;
    </th>

    {{-- GROUP ICON --}}
    <th scope="col" width="85">
      &nbsp;
    </th>

    {{-- PARTCIPANTS --}}
    <th scope="col" width="60" class="text-center d-none d-md-table-cell" data-toggle="tooltip" data-placement="bottom" title="Participants">
      @include('svgs/navigation/groups-icon')
    </th>

    {{-- RESTARTERS --}}
    <th scope="col" width="60" class="text-center d-none d-md-table-cell" data-toggle="tooltip" data-placement="bottom" title="Repairers">
      @include('svgs/navigation/drill-icon')
    </th>

    {{-- WASTE PREVENTED --}}
    <th scope="col" width="60" class="text-center" data-toggle="tooltip" data-placement="bottom" title="Waste prevented (kg)">
      @include('svgs/fixometer/trash-ico')
    </th>

    {{-- CO2 EMISSIONS PREVENTED --}}
    <th scope="col" width="60" class="text-center" data-toggle="tooltip" data-placement="bottom" title="CO2 emissions prevented (kg)">
      @include('svgs/fixometer/co-2-ico')
    </th>

    {{-- FIXED DEVICES --}}
    <th scope="col" width="60" class="text-center d-none d-md-table-cell" data-toggle="tooltip" data-placement="bottom" title="Fixed devices">
      @include('svgs/fixometer/ic-directions-round')
    </th>

    {{-- REPAIRABLE DEVICES --}}
    <th scope="col" width="60" class="text-center d-none d-md-table-cell" data-toggle="tooltip" data-placement="bottom" title="Repairable devices">
      @include('svgs/fixometer/thumbs-up-ico')
    </th>

    {{-- DEAD DEVICES --}}
    <th scope="col" width="60" class="text-center d-none d-md-table-cell" data-toggle="tooltip" data-placement="bottom" title="End-of-life devices">
      @include('svgs/fixometer/dead-ico')
    </th>
  </tr>
</thead>
