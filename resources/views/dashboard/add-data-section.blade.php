<div class="card card-info-box bg-primary">
  <div class="card-body text-dark pt-0">
    <div class="d-flex flex-row align-items-center">
      <h2 class="mb-0 mr-30 mt-10">
        @lang('dashboard.add_data_title')
      </h2>

      <div class="mr-auto">
        @include('svgs.fixometer.fixometer-doodle', [
          'offset_top' => 10,
          'height' => 66,
        ])
      </div>
    </div>

    <hr class="hr-dashed mb-25 mt-10">

    <p>
      @lang('dashboard.add_data_description')
    </p>

    <div class="flex-dynamic-row">
      <div class="flex-dynamic mb-20 mb-md-0">
        <label for="items_cat" class="sr-only">@lang('devices.group'):<</label>
        <div class="form-control form-control__select">
          <select id="group" name="group" class="form-control select2-group change-group" title="Choose group...">
            @if( ! $user_groups->isEmpty() )
              @foreach($user_groups as $group)
                <option value="{{ $group->idgroups }}">
                  {{ $group->name }}
                </option>
              @endforeach
            @endif
          </select>
        </div>
      </div>

      <div class="flex-dynamic mb-20 mb-md-0">
        <label for="items_cat" class="sr-only">@lang('devices.category'):</label>
        <div class="form-control form-control__select">
          <select id="events" name="events" class="form-control select2 change-events" title="Choose event...">
          </select>
        </div>
      </div>

      {{-- TODO: Add Data URL --}}
      <a href="#" class="btn btn-primary btn-sm w-min-auto change-event-url">
        Add
      </a>
    </div>
  </div>
</div>
