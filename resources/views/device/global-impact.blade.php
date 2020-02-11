<div class="col-12 my-30">
  <div class="d-flex align-items-center justify-content-between">
    <h2 class="mb-0">
      Our Global Impact
    </h2>

    @if (isset($most_recent_finished_event) && ! empty($most_recent_finished_event))
      <div class="d-none d-md-block">
        <div class="call_to_action">
          <div class="mr-30">
            @include('svgs.fixometer.clap_doodle')
          </div>

          {{ $most_recent_finished_event->theGroup->name }} prevented {{ $most_recent_finished_event->WastePrevented }}kg of waste!
        </div>
      </div>
    @endif
  </div>
</div>

<div class="col-12">
  <div class="row">
    <div class="col d-none d-md-block mb-30">
      <div class="card card-summary">
        <div class="card-body">
          <div class="svg-wrapper">
            @include('svgs.fixometer.smile_doodle')
          </div>

          <h3>{{ $global_impact_data->participants }}</h3>
          <p>participants</p>
        </div>
      </div>
    </div>

    <div class="col mb-30">
      <div class="card card-summary">
        <div class="card-body">
          <div class="svg-wrapper">
            @include('svgs.fixometer.clock_doodle')
          </div>
          <h3>{{ $global_impact_data->hours_volunteered }}</h3>
          <p>hours of volunteered time</p>
        </div>
      </div>
    </div>

    <div class="col mb-30">
      <div class="card card-summary">
        <div class="card-body">
          <div class="svg-wrapper">
            @include('svgs.fixometer.phone_doodle')
          </div>
          <h3>{{ $global_impact_data->items_fixed }}</h3>
          <p>devices repaired</p>
        </div>
      </div>
    </div>

    <div class="col mb-30">
      <div class="card card-summary">
        <div class="card-body">
          {{-- TODO --}}
          <div class="svg-wrapper">

          </div>

          <h3>{{ $global_impact_data->waste_prevented }}</h3>
          <p>waste prevented</p>
        </div>
      </div>
    </div>

    <div class="col mb-30">
      <div class="card card-summary">
        <div class="card-body">
          {{-- TODO --}}
          <div class="svg-wrapper">

          </div>

          <h3>{{ number_format($global_impact_data->emissions, 0) }}</h3>
          <p>CO2 emissinos prevented</p>
        </div>
      </div>
    </div>
  </div>
</div>
