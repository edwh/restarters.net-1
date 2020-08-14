<div class="col-12">
  <h2 class="mb-25">
    Search Repair Data
  </h2>

  <div class="collapse offset-md-box-shadow d-md-block show" id="collapseSearchFilters">
    <div class="nav-md-tabs">
      <ul id="tabs" class="nav nav-tabs nav-tabs-block nav-md-tabs" role="tablist">
        <li class="nav-item">
          <a id="tab-A" href="#pane-A" class="nav-link active" data-toggle="tab" role="tab">
            @lang('devices.device_info')
          </a>

          @if( empty($_GET) || !empty($selected_categories) || !empty($brand) || !empty($model) )
            @php( $active_filter = true )
          @endif
        </li>
        <li class="nav-item">
          <a id="tab-B" href="#pane-B" class="nav-link" data-toggle="tab" role="tab">
            @lang('devices.repair_info')
          </a>

          @if( !empty($status) || !empty($problem) || !empty($wiki) )
            @php( $active_filter = true )
          @endif
        </li>
        <li class="nav-item">
          <a id="tab-C" href="#pane-C" class="nav-link" data-toggle="tab" role="tab">
            @lang('devices.event_info')
          </a>

          @if( !empty($selected_groups) || !empty($from_date) || !empty($to_date) )
            @php( $active_filter = true )
          @endif
        </li>
        <li class="nav-item">
          <a id="tab-D" href="#pane-D" class="nav-link" data-toggle="tab" role="tab">
            Group Info
          </a>
        </li>
      </ul>

      <div id="content" class="tab-content deviceFilterContainer" role="tablist">
        <div id="pane-A" class="tab-pane fade show active" role="tabpanel" aria-labelledby="tab-A">
          <div class="accordion-tab-header collapse-plus-and-minus" role="tab" id="heading-A">
            <button class="btn" type="button" data-toggle="collapse" data-target="#collapse-A" aria-expanded="true" aria-controls="collapse-A">
              <h5>
                @lang('devices.device_info')
              </h5>
            </button>
          </div>

          <div id="collapse-A" class="collapse collapse-wrapper show" data-parent="#content" role="tabpanel" aria-labelledby="heading-A">
            <div class="collapse-content">
              <div class="row">
                <div class="col-12 col-md-4 form-group mb-3 mb-md-0">
                  <label for="items_cat" class="sr-only">@lang('devices.category'):</label>
                  <div class="form-control form-control__select">
                    <select id="categories" name="categories[]" class="form-control select2-categories" multiple title="Choose categories...">
                      @if(isset($categories))
                        @foreach($categories as $cluster)
                          <optgroup label="<?php echo $cluster->name; ?>">
                            @foreach($cluster->categories as $c)
                              <option value="<?php echo $c->idcategories; ?>" @if (!empty($selected_categories) && in_array($c->idcategories, $selected_categories)) selected @endif>
                                <?php echo $c->name; ?>
                              </option>
                            @endforeach
                          </optgroup>
                        @endforeach
                      @endif
                      <option value="46">Misc</option>
                    </select>
                  </div>
                </div>

                <div class="col-12 col-md-4 form-group mb-3 mb-md-0">
                  <label for="brand" class="sr-only">@lang('devices.device_brand'):</label>
                  <input type="text" class="form-control field" id="brand" name="brand"
                  placeholder="@lang('devices.device_brand')" value="{{ $brand }}">
                </div>

                <div class="col-12 col-md-4 form-group mb-3 mb-md-0">
                  <label for="model" class="sr-only">@lang('devices.device_model'):</label>
                  <input type="text" class="form-control field" id="model" name="model"
                  placeholder="@lang('devices.device_model')" value="{{ $model }}">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div id="pane-B" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-B">
          <div class="accordion-tab-header collapse-plus-and-minus" role="tab" id="heading-B">
            <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#collapse-B" aria-expanded="true" aria-controls="collapse-B">
              <h5>
                @lang('devices.repair_info')
              </h5>
            </button>
          </div>

          <div id="collapse-B" class="collapse collapse-wrapper" data-parent="#content" role="tabpanel" aria-labelledby="heading-B">
            <div class="collapse-content">
              <div class="row">
                <div class="col-12 col-md-4 form-group mb-3 mb-md-0">
                  <label for="status" class="sr-only">Repair Status:</label>
                  <div class="form-control form-control__select">
                    <select id="status" name="status[]" class="form-control select2-repair-status" multiple title="Device status...">
                      <option @if (! empty($status) && in_array(1, $status)) selected @endif value="1">
                        Fixed
                      </option>
                      <option @if (! empty($status) && in_array(2, $status)) selected @endif value="2">
                        Repairable
                      </option>
                      <option @if (! empty($status) && in_array(3, $status)) selected @endif value="3">
                        End
                      </option>
                    </select>
                  </div>
                </div>

                <div class="col-12 col-md-4 form-group mb-3 mb-md-0">
                  <label for="problem" class="sr-only">@lang('devices.search_comments'):</label>
                  <input type="text" class="form-control field" id="problem" name="problem"
                  placeholder="@lang('devices.search_comments')" value="{{ $problem }}">
                </div>

                <div class="col-12 col-md-4 form-group mb-3 mb-md-0">
                  <label for="suitable-for-wiki" class="sr-only">@lang('devices.suitable'):</label>
                  <div class="d-flex flex-row align-items-start">
                    <input type="checkbox" id="suitable-for-wiki" name="wiki" value="1" {{ $wiki ? 'checked' : '' }}
                    placeholder="@lang('devices.suitable')" class="ml-0 mr-3"/>
                    <label class="form-text-corrected" for="suitable-for-wiki">@lang('devices.suitable_help')</label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div id="pane-C" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-C">
          <div class="accordion-tab-header collapse-plus-and-minus" role="tab" id="heading-C">
            <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#collapse-C" aria-expanded="true" aria-controls="collapse-C">
              <h5>
                @lang('devices.event_info')
              </h5>
            </button>
          </div>

          <div id="collapse-C" class="collapse collapse-wrapper" data-parent="#content" role="tabpanel" aria-labelledby="heading-C">
            <div class="collapse-content">
              <div class="row">
                <div class="col-12 col-md-4 form-group mb-3 mb-md-0">
                  <label for="from-date" class="sr-only">@lang('devices.from_date'):</label>
                  <input type="date" class="field form-control" id="search-from-date" name="from-date"
                  value="{{ $from_date }}" placeholder="@lang('devices.from_date')" onfocus="(this.type='date')" onblur="(this.type='text')">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>

                <div class="col-12 col-md-4 form-group mb-3 mb-md-0">
                  <label for="to-date" class="sr-only">@lang('devices.to_date'):</label>
                  <input type="date" class="field form-control" id="search-to-date" name="to-date"
                  value="{{ $to_date }}" placeholder="@lang('devices.to_date')" onfocus="(this.type='date')" onblur="(this.type='text')">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div id="pane-D" class="tab-pane fade" role="tabpanel" aria-labelledby="tab-D">
          <div class="accordion-tab-header collapse-plus-and-minus" role="tab" id="heading-D">
            <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#collapse-D" aria-expanded="true" aria-controls="collapse-D">
              <h5>
                Group Info
              </h5>
            </button>
          </div>

          <div id="collapse-D" class="collapse collapse-wrapper" data-parent="#content" role="tabpanel" aria-labelledby="heading-D">
            <div class="collapse-content">
              <div class="col-12 col-md-4 form-group mb-3 mb-md-0">
                <label for="items_group" class="sr-only">@lang('devices.group'):</label>
                <div class="form-control form-control__select">
                  <select id="groups" name="groups[]" class="form-control select2-group" multiple data-live-search="true" title="Choose groups...">
                    @if(isset($groups))
                      @foreach($groups as $g)
                        <option value="<?php echo $g->idgroups; ?>" @if (!empty($selected_groups) && in_array($g->idgroups, $selected_groups)) selected @endif>
                          <?php echo $g->name; ?>
                        </option>
                      @endforeach
                    @endif
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="nav-tab-summary-section">
      <button type="submit" name="button" class="btn btn-sm btn-primary mr-40">
        @include('svgs.fixometer.search_ico')
      </button>

      <h2 class="mb-0">{{ isset($list) ? $list->total() : $impact_data->items_fixed }} results</h2>
    </div>
  </div>

  <div class="d-block d-md-none text-right mt-10">
    <a class="collapse-plus-and-minus-controller" data-close-text="Close Filters" data-open-text="Open Filters" data-toggle="collapse" href="#collapseSearchFilters" aria-expanded="false" aria-controls="collapseSearchFilters">
      Close Filters
    </a>

    <hr class="m-0 hr-sm">
  </div>
</div>
