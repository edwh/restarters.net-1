<tr id="summary-{{ $device->iddevices }}">
    <td><a class="collapsed row-button" id="open-edit-device" data-toggle="collapse" href="#row-{{ $device->iddevices }}" role="button" aria-expanded="false" aria-controls="row-1">
    @if( ( Auth::check() && ( FixometerHelper::hasRole(Auth::user(), 'Administrator') || FixometerHelper::userHasEditPartyPermission($device->event, Auth::user()->id) ) ) || ( is_object($is_attending) && $is_attending->status == 1 ) )
      Edit
    @else
      View
    @endif
    <span class="arrow">▴</span></a></td>
    <td class="text-center">0</td>
    <td class="d-none d-md-table-cell"><div class="category">{{ $device->deviceCategory->name }}</div></td>
    <td class="d-none d-md-table-cell"><div class="brand">{{ $device->brand }}</div></td>
    <td class="d-none d-md-table-cell"><div class="model">{{ $device->model }}</div></td>
    <td class="d-none d-md-table-cell"><div class="age">{{ $device->age }}</div></td>
    <td width="300"><div class="problem">{!! $device->getShortProblem() !!}</div></td>
    @if ( $device->repair_status == 1 )
      <td><div class="repair_status"><span class="badge badge-success">@lang('partials.fixed')</span></div></td>
    @elseif ( $device->repair_status == 2 )
      <td><div class="repair_status"><span class="badge badge-warning">@lang('partials.repairable')</span></div></td>
    @elseif ( $device->repair_status == 3 )
      <td><div class="repair_status"><span class="badge badge-danger">@lang('partials.end')</span></div></td>
    @else
      <td><div class="repair_status"></div></td>
    @endif
    <?php /*
    @if ($device->more_time_needed == 1)
      <td><div class="repair_details">@lang('partials.more_time')</div></td>
    @elseif ($device->professional_help == 1)
      <td><div class="repair_details">@lang('partials.professional_help')</div></td>
    @elseif ($device->do_it_yourself == 1)
      <td><div class="repair_details">@lang('partials.diy')</div></td>
    @else
      <td><div class="repair_details">N/A</div></td>
    @endif*/ ?>
    <td>
      <svg @if ( $device->spare_parts == 0 || $device->spare_parts == 2 ) style="display: none;" @endif class="table-tick" width="21" height="17" viewBox="0 0 16 13" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;position:relative;z-index:1"><g><path d="M5.866,12.648l2.932,-2.933l-5.865,-5.866l-2.933,2.933l5.866,5.866Z" style="fill:#0394a6;"/><path d="M15.581,2.933l-2.933,-2.933l-9.715,9.715l2.933,2.933l9.715,-9.715Z" style="fill:#0394a6;"/></g></svg>
    </td>
    @if( Auth::check() && ( FixometerHelper::hasRole(Auth::user(), 'Administrator') || FixometerHelper::userHasEditPartyPermission($device->event, Auth::user()->id) ) )
    <td class="d-none d-md-table-cell"><a data-device-id="{{{ $device->iddevices }}}" class="row-button delete-device" href="{{ url('/device/delete/'.$device->iddevices) }}"><svg width="15" height="15" viewBox="0 0 12 12" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;"><g><g opacity="0.5"><path d="M11.25,10.387l-10.387,-10.387l-0.863,0.863l10.387,10.387l0.863,-0.863Z"/><path d="M0.863,11.25l10.387,-10.387l-0.863,-0.863l-10.387,10.387l0.863,0.863Z"/></g></g></svg></a></td>
    @endif
</tr>
@if( ( Auth::check() && ( FixometerHelper::hasRole(Auth::user(), 'Administrator') || FixometerHelper::userHasEditPartyPermission($device->event, Auth::user()->id) ) ) || ( is_object($is_attending) && $is_attending->status == 1 ) )
<tr class="collapse table-row-details" id="row-{{ $device->iddevices }}">
    <td colspan="11">
        <form id="data-{{ $device->iddevices }}" class="edit-device" data-device="{{ $device->iddevices }}" method="post" enctype="multipart/form-data">

        <div class="row row-compressed-xs nested-fields d-lg-table col-lg-12">

          <div class="col-12 col-sm-6 col-device-auto">

            <label for="category-{{ $device->iddevices }}">@lang('partials.category'):</label>
            <div class="form-control form-control__select">
                <select name="category-{{ $device->iddevices }}" id="category-{{ $device->iddevices }}" class="category select2">
                    <option value="">@lang('general.please_select')</option>
                    @foreach( $clusters as $cluster )
                    <optgroup label="{{{ $cluster->name }}}">
                        @foreach( $cluster->categories as $category )
                          @if( $device->category == $category->idcategories )
                            <option value="{{{ $category->idcategories }}}" selected>{{{ $category->name }}}</option>
                          @else
                            <option value="{{{ $category->idcategories }}}">{{{ $category->name }}}</option>
                          @endif
                        @endforeach
                    </optgroup>
                    @endforeach
                    @if( $device->category == 46 )
                      <option value="46" selected>@lang('partials.category_none')</option>
                    @else
                      <option value="46">@lang('partials.category_none')</option>
                    @endif
                </select>
            </div>
            @if( $device->category == 46 )
              <div class="display-weight pt-1 mb-2">
                  <div class="input-group">
                    <input type="number" class="form-control field weight" id="weight-{{ $device->iddevices }}" name="weight" min="0.01" step=".01" placeholder="@lang('partials.est_weight')" autocomplete="off" value="{{ $device->estimate }}">
                    <div class="input-group-append">
                      <span class="input-group-text">kg</span>
                    </div>
                  </div>
              </div>
            @else
              <div class="display-weight d-none">
                  <div class="input-group">
                    <input disabled type="number" class="form-control field weight" id="weight-{{ $device->iddevices }}" name="weight" min="0.01" step=".01" placeholder="@lang('partials.est_weight')" autocomplete="off" value="{{ $device->estimate }}">
                    <div class="input-group-append">
                      <span class="input-group-text">kg</span>
                    </div>
                  </div>
              </div>
            @endif

          </div>

          <div class="col-12 col-sm-6 form-group col-device-auto">
            <label for="brand-{{ $device->iddevices }}" class="flex-0">@lang('devices.brand'):</label>
            <div class="form-control form-control__select">
                <select name="brand-{{ $device->iddevices }}" class="select2-with-input" id="brand-{{ $device->iddevices }}">
                    @php($i = 1)
                    @if( empty($device->brand) )
                      <option value="" selected></option>
                    @else
                      <option value=""></option>
                    @endif
                    @foreach($brands as $brand)
                      @if ($device->brand == $brand->brand_name)
                        <option value="{{ $brand->brand_name }}" selected>{{ $brand->brand_name }}</option>
                        @php($i++)
                      @else
                        <option value="{{ $brand->brand_name }}">{{ $brand->brand_name }}</option>
                      @endif
                    @endforeach
                    @if( $i == 1 && !empty($device->brand) )
                      <option value="{{ $device->brand }}" selected>{{ $device->brand }}</option>
                    @endif
                </select>
            </div>
          </div>

          <div class="col-7 col-sm-6 col-device-auto">
            <label for="nested-6">@lang('partials.model'):</label>
            <div class="form-group">
                <input type="text" class="form-control field" id="model-{{ $device->iddevices }}" name="model-{{ $device->iddevices }}" value="{{ $device->model }}" placeholder="@lang('partials.model')" autocomplete="off">
            </div>
          </div>

          <div class="col-5 col-device-auto">
            <label for="age-{{ $device->iddevices }}">@lang('partials.age'):</label>
            <div class="form-group">
              <input type="number" class="form-control field" id="age-{{ $device->iddevices }}" name="age-{{ $device->iddevices }}" min="0" step="0.5" value="{{ $device->age }}" placeholder="@lang('partials.age_placeholder')" autocomplete="off">
            </div>
          </div>

          <div class="col-12 col-sm-4 form-group col-device-auto">
            <label for="status-{{ $device->iddevices }}">@lang('partials.status'):</label>
            <div class="form-control form-control__select">
                <select class="select2 repair-status" name="repair_status" id="status-{{ $device->iddevices }}" data-device="{{ $device->iddevices }}" placeholder="Description of problem">
                  <option value="0">@lang('general.please_select')</option>
                  @if ( $device->repair_status == 1 )
                    <option value="1" selected>@lang('partials.fixed')</option>
                    <option value="2">@lang('partials.repairable')</option>
                    <option value="3">@lang('partials.end_of_life')</option>
                  @elseif ( $device->repair_status == 2 )
                    <option value="1">@lang('partials.fixed')</option>
                    <option value="2" selected>@lang('partials.repairable')</option>
                    <option value="3">@lang('partials.end_of_life')</option>
                  @else
                    <option value="1">@lang('partials.fixed')</option>
                    <option value="2">@lang('partials.repairable')</option>
                    <option value="3" selected>@lang('partials.end_of_life')</option>
                  @endif
                </select>
            </div>
          </div>

          <div class="col-12 col-sm-4 form-group col-device <?php echo ($device->repair_status == 2 ? 'col-device-auto' : 'd-none'); ?>">
            <label for="repair-info-{{ $device->iddevices }}">@lang('partials.repair_details'):</label>
            <div class="form-control form-control__select">
                <select class="repair_details select2 repair-details-edit" name="repair-info" id="repair-info-{{ $device->iddevices }}">
                  <option value="0">@lang('general.please_select')</option>
                  @if ( $device->more_time_needed == 1 )
                    <option value="1" selected>@lang('partials.more_time')</option>
                    <option value="2">@lang('partials.professional_help')</option>
                    <option value="3">@lang('partials.diy')</option>
                  @elseif ( $device->professional_help == 1 )
                    <option value="1">@lang('partials.more_time')</option>
                    <option value="2" selected>@lang('partials.professional_help')</option>
                    <option value="3">@lang('partials.diy')</option>
                  @elseif ( $device->do_it_yourself == 1 )
                    <option value="1" >@lang('partials.more_time')</option>
                    <option value="2">@lang('partials.professional_help')</option>
                    <option value="3" selected>@lang('partials.diy')</option>
                  @else
                    <option value="1">@lang('partials.more_time')</option>
                    <option value="2">@lang('partials.professional_help')</option>
                    <option value="3">@lang('partials.diy')</option>
                  @endif
                </select>
            </div>
          </div>

          <div class="col-12 col-sm-4 form-group col-device <?php echo ($device->repair_status == 1 || $device->repair_status == 2 ? 'col-device-auto' : 'd-none'); ?>">
            <label for="spare-parts-{{ $device->iddevices }}">@lang('devices.spare_parts_required'):</label>
            <div class="form-control form-control__select">
                <select class="select2 spare-parts" name="spare-parts-{{ $device->iddevices }}" id="spare-parts-{{ $device->iddevices }}">
                  <option @if ( $device->spare_parts == 1 && is_null($device->parts_provider) ) value="4" @else value="0" @endif>@lang('general.please_select')</option>
                  <option value="1" @if ( $device->spare_parts == 1 && !is_null($device->parts_provider) ) selected @endif>@lang('partials.yes_manufacturer')</option>
                  <option value="3" @if ( $device->parts_provider == 2 ) selected @endif>@lang('partials.yes_third_party')</option>
                  <option value="2" @if ( $device->spare_parts == 2 ) selected @endif>@lang('partials.no')</option>
                </select>
            </div>
          </div>

          <div class="col-12 col-sm-12 col-md-4 form-group col-device <?php echo ($device->repair_status == 3 ? 'col-device-auto' : 'd-none'); ?>">
            <label for="repair_barrier">@lang('devices.repair_barrier'):</label>
            <div class="form-control form-control__select form-control__select_placeholder">
              <select name="barrier-{{ $device->iddevices }}[]" multiple id="barrier-{{ $device->iddevices }}" class="form-control field select2-repair-barrier repair-barrier">
                <option></option>
                @foreach( FixometerHelper::allBarriers() as $barrier )
                  <option value="{{{ $barrier->id }}}" @if ( $device->barriers->contains($barrier->id) ) selected @endif>{{{ $barrier->barrier }}}</option>
                @endforeach
              </select>
            </div>
          </div>

        </div><!-- /row -->
        <div class="row row-compressed-xs nested-fields table-row-more">
          <div class="col-12 col-lg-6 flex-column d-flex">

              <label for="problem-{{ $device->iddevices }}">@lang('partials.description_of_problem_solution'):</label>
              <div class="form-group">
                  <textarea class="form-control" rows="6" name="problem-{{ $device->iddevices }}" id="problem-{{ $device->iddevices }}">{!! $device->problem !!}</textarea>
              </div>

              @include('partials.useful-repair-urls', ['urls' => $device->urls, 'device' => $device])

          </div>
          <div class="col-12 col-lg-6 flex-column d-flex">

            <div class="table-cell-upload">

              <div class="row mt-4">
                  <div class="col-md-12 d-flex align-content-center flex-column">
                      <div class="form-check d-flex align-items-center justify-content-start">
                          <input class="form-check-input" type="checkbox" name="wiki-{{ $device->iddevices }}" id="wiki-{{ $device->iddevices }}" value="1" @if( $device->wiki == 1 ) checked @endif>
                          <label class="form-check-label" for="wiki-{{ $device->iddevices }}">@lang('partials.solution_text')</label>
                      </div>
                  </div>
                  <div class="col-md-12 d-flex justify-content-end flex-column"><div class="d-flex justify-content-end">
                      <button type="submit" class="btn btn-primary btn-save2">@lang('partials.save')</button></div>
                  </div>
              </div>

            </div><!-- / table-cell-upload -->

          </div>

        </div><!-- /row -->

        </form>

        <div class="row row-compressed-xs nested-fields table-row-more">
          <div class="col-12 col-lg-6 flex-column d-flex">
              <div class="form-group">
                  <label>@lang('partials.add_image'):</label>

                  <form id="dropzoneEl-{{ $device->iddevices }}" data-deviceid="{{ $device->iddevices }}" class="dropzone dropzoneEl" action="/device/image-upload/{{ $device->iddevices }}" method="post" enctype="multipart/form-data"data-field1="@lang('events.field_event_device_images')" data-field2="@lang('events.field_event_device_images_2')">
                      @csrf
                      <div class="fallback">
                          <input id="file-{{ $device->iddevices }}" name="file-{{ $device->iddevices }}" type="file" multiple />
                      </div>
                  </form>
              </div>
            </div>
            <div class="col-12 col-lg-6 device-images">
              <label for="device-image-{{ $device->iddevices }}">@lang('partials.device_images'):</label>
              <div class="previews">
                @if( isset($device_images[$device->iddevices]) && !empty($device_images[$device->iddevices]) )
                  @foreach($device_images[$device->iddevices] as $device_image)
                    <div id="device-image-{{ $device->iddevices }}" class="dz-image">
                      <a href="/uploads/{{ $device_image->path }}" data-toggle="lightbox">
                        <img src="/uploads/thumbnail_{{ $device_image->path }}" alt="placeholder">
                      </a>
                      <a href="/device/image/delete/{{ $device->iddevices }}/{{{ $device_image->idimages }}}/{{{ $device_image->path }}}" data-device-id="{{ $device->iddevices }}" class="dz-remove ajax-delete-image">@lang('partials.remove_file')</a>
                    </div>
                  @endforeach
                @endif
                <div class="uploads-{{ $device->iddevices }}"></div>
              </div>
          </div>
        </div>

    </td>
</tr>
@else
<tr class="collapse table-row-details" id="row-{{ $device->iddevices }}">
    <td colspan="11">

        <div class="row row-compressed-xs nested-fields d-lg-table col-lg-12">

          <div class="col-12 col-sm-6 col-device-auto">

            <label for="category-{{ $device->iddevices }}">@lang('partials.category'):</label>
            <div class="form-control form-control__select">
                <select disabled name="category-{{ $device->iddevices }}" id="category-{{ $device->iddevices }}" class="category select2">
                    <option value="">@lang('general.please_select')</option>
                    @foreach( $clusters as $cluster )
                    <optgroup label="{{{ $cluster->name }}}">
                        @foreach( $cluster->categories as $category )
                          @if( $device->category == $category->idcategories )
                            <option value="{{{ $category->idcategories }}}" selected>{{{ $category->name }}}</option>
                          @else
                            <option value="{{{ $category->idcategories }}}">{{{ $category->name }}}</option>
                          @endif
                        @endforeach
                    </optgroup>
                    @endforeach
                    @if( $device->category == 46 )
                      <option value="46" selected>@lang('partials.category_none')</option>
                    @else
                      <option value="46">@lang('partials.category_none')</option>
                    @endif
                </select>
            </div>
            @if( $device->category == 46 )
              <div class="display-weight pt-1 mb-2">
                  <div class="input-group">
                    <input disabled type="number" class="form-control field weight" id="weight-{{ $device->iddevices }}" name="weight" min="0.01" step=".01" placeholder="@lang('partials.est_weight')" autocomplete="off" value="{{ $device->estimate }}">
                    <div class="input-group-append">
                      <span class="input-group-text">kg</span>
                    </div>
                  </div>
              </div>
            @else
              <div class="display-weight d-none">
                  <div class="input-group">
                    <input disabled type="number" class="form-control field weight" id="weight-{{ $device->iddevices }}" name="weight" min="0.01" step=".01" placeholder="@lang('partials.est_weight')" autocomplete="off" value="{{ $device->estimate }}">
                    <div class="input-group-append">
                      <span class="input-group-text">kg</span>
                    </div>
                  </div>
              </div>
            @endif

          </div>

          <div class="col-12 col-sm-6 form-group col-device-auto">
            <label for="brand-{{ $device->iddevices }}" class="flex-0">@lang('devices.brand'):</label>
            <div class="form-control form-control__select">
                <select disabled name="brand-{{ $device->iddevices }}" class="select2-with-input" id="brand-{{ $device->iddevices }}">
                    @php($i = 1)
                    @if( empty($device->brand) )
                      <option value="" selected></option>
                    @else
                      <option value=""></option>
                    @endif
                    @foreach($brands as $brand)
                      @if ($device->brand == $brand->brand_name)
                        <option value="{{ $brand->brand_name }}" selected>{{ $brand->brand_name }}</option>
                        @php($i++)
                      @else
                        <option value="{{ $brand->brand_name }}">{{ $brand->brand_name }}</option>
                      @endif
                    @endforeach
                    @if( $i == 1 && !empty($device->brand) )
                      <option value="{{ $device->brand }}" selected>{{ $device->brand }}</option>
                    @endif
                </select>
            </div>
          </div>

          <div class="col-7 col-sm-6 col-device-auto">
            <label for="nested-6">@lang('partials.model'):</label>
            <div class="form-group">
                <input disabled type="text" class="form-control field" id="model-{{ $device->iddevices }}" name="model-{{ $device->iddevices }}" value="{{ $device->model }}" placeholder="@lang('partials.model')" autocomplete="off">
            </div>
          </div>

          <div class="col-5 col-device-auto">
            <label for="age-{{ $device->iddevices }}">@lang('partials.age'):</label>
            <div class="form-group">
              <input disabled type="number" class="form-control field" id="age-{{ $device->iddevices }}" name="age-{{ $device->iddevices }}" min="0" step="0.5" value="{{ $device->age }}" placeholder="@lang('partials.age_placeholder')" autocomplete="off">
            </div>
          </div>

          <div class="col-12 col-sm-4 form-group col-device-auto">
            <label for="status-{{ $device->iddevices }}">@lang('partials.status'):</label>
            <div class="form-control form-control__select">
                <select disabled class="select2 repair-status" name="repair_status" id="status-{{ $device->iddevices }}" data-device="{{ $device->iddevices }}" placeholder="Description of problem">
                  <option value="0">@lang('general.please_select')</option>
                  @if ( $device->repair_status == 1 )
                    <option value="1" selected>@lang('partials.fixed')</option>
                    <option value="2">@lang('partials.repairable')</option>
                    <option value="3">@lang('partials.end_of_life')</option>
                  @elseif ( $device->repair_status == 2 )
                    <option value="1">@lang('partials.fixed')</option>
                    <option value="2" selected>@lang('partials.repairable')</option>
                    <option value="3">@lang('partials.end_of_life')</option>
                  @else
                    <option value="1">@lang('partials.fixed')</option>
                    <option value="2">@lang('partials.repairable')</option>
                    <option value="3" selected>@lang('partials.end_of_life')</option>
                  @endif
                </select>
            </div>
          </div>

          <div class="col-12 col-sm-4 form-group col-device <?php echo ($device->repair_status == 2 ? 'col-device-auto' : 'd-none'); ?>">
            <label for="repair-info-{{ $device->iddevices }}">@lang('partials.repair_details'):</label>
            <div class="form-control form-control__select">
                <select disabled class="repair_details select2 repair-details-edit" name="repair-info" id="repair-info-{{ $device->iddevices }}">
                  <option value="0">@lang('general.please_select')</option>
                  @if ( $device->more_time_needed == 1 )
                    <option value="1" selected>@lang('partials.more_time')</option>
                    <option value="2">@lang('partials.professional_help')</option>
                    <option value="3">@lang('partials.diy')</option>
                  @elseif ( $device->professional_help == 1 )
                    <option value="1">@lang('partials.more_time')</option>
                    <option value="2" selected>@lang('partials.professional_help')</option>
                    <option value="3">@lang('partials.diy')</option>
                  @elseif ( $device->do_it_yourself == 1 )
                    <option value="1" >@lang('partials.more_time')</option>
                    <option value="2">@lang('partials.professional_help')</option>
                    <option value="3" selected>@lang('partials.diy')</option>
                  @else
                    <option value="1">@lang('partials.more_time')</option>
                    <option value="2">@lang('partials.professional_help')</option>
                    <option value="3">@lang('partials.diy')</option>
                  @endif
                </select>
            </div>
          </div>

          <div class="col-12 col-sm-4 form-group col-device <?php echo ($device->repair_status == 1 || $device->repair_status == 2 ? 'col-device-auto' : 'd-none'); ?>">
            <label for="spare-parts-{{ $device->iddevices }}">@lang('devices.spare_parts_required'):</label>
            <div class="form-control form-control__select">
                <select disabled class="select2 spare-parts" name="spare-parts-{{ $device->iddevices }}" id="spare-parts-{{ $device->iddevices }}">
                  <option @if ( $device->spare_parts == 1 && is_null($device->parts_provider) ) value="4" @else value="0" @endif>@lang('general.please_select')</option>
                  <option value="1" @if ( $device->spare_parts == 1 && !is_null($device->parts_provider) ) selected @endif>@lang('partials.yes_manufacturer')</option>
                  <option value="3" @if ( $device->parts_provider == 2 ) selected @endif>@lang('partials.yes_third_party')</option>
                  <option value="2" @if ( $device->spare_parts == 2 ) selected @endif>@lang('partials.no')</option>
                </select>
            </div>
          </div>

          <div class="col-12 col-sm-12 col-md-4 form-group col-device <?php echo ($device->repair_status == 3 ? 'col-device-auto' : 'd-none'); ?>">
            <label for="repair_barrier">@lang('devices.repair_barrier'):</label>
            <div class="form-control form-control__select form-control__select_placeholder">
              <select disabled name="barrier-{{ $device->iddevices }}[]" multiple id="barrier-{{ $device->iddevices }}" class="form-control field select2-repair-barrier repair-barrier">
                <option></option>
                @foreach( FixometerHelper::allBarriers() as $barrier )
                  <option value="{{{ $barrier->id }}}" @if ( $device->barriers->contains($barrier->id) ) selected @endif>{{{ $barrier->barrier }}}</option>
                @endforeach
              </select>
            </div>
          </div>

        </div><!-- /row -->
        <div class="row row-compressed-xs nested-fields table-row-more">
          <div class="col-12 col-lg-6 flex-column d-flex">

              <label for="problem-{{ $device->iddevices }}">@lang('partials.description_of_problem_solution'):</label>
              <div class="form-group">
                  <textarea disabled class="form-control" rows="6" name="problem-{{ $device->iddevices }}" id="problem-{{ $device->iddevices }}">{!! $device->problem !!}</textarea>
              </div>

              @include('partials.useful-repair-urls', ['urls' => $device->urls, 'device' => $device])

          </div>
          <div class="col-12 col-lg-6 flex-column d-flex">

            <div class="table-cell-upload">

              <div class="row mt-4">
                  <div class="col-md-12 d-flex align-content-center flex-column">
                      <div class="form-check d-flex align-items-center justify-content-start">
                          <input disabled class="form-check-input" type="checkbox" name="wiki-{{ $device->iddevices }}" id="wiki-{{ $device->iddevices }}" value="1" @if( $device->wiki == 1 ) checked @endif>
                          <label class="form-check-label" for="wiki-{{ $device->iddevices }}">@lang('partials.solution_text')</label>
                      </div>
                  </div>
              </div>

            </div><!-- / table-cell-upload -->

          </div>

        </div><!-- /row -->

        <div class="row row-compressed-xs nested-fields table-row-more">
            <div class="col-12 col-lg-6 device-images">
              <label for="device-image-{{ $device->iddevices }}">@lang('partials.device_images'):</label>
              <div class="previews">
                @if( isset($device_images[$device->iddevices]) && !empty($device_images[$device->iddevices]) )
                  @foreach($device_images[$device->iddevices] as $device_image)
                    <div id="device-image-{{ $device->iddevices }}" class="dz-image">
                      <a href="/uploads/{{ $device_image->path }}" data-toggle="lightbox">
                        <img src="/uploads/thumbnail_{{ $device_image->path }}" alt="placeholder">
                      </a>
                      <a href="/device/image/delete/{{ $device->iddevices }}/{{{ $device_image->idimages }}}/{{{ $device_image->path }}}" data-device-id="{{ $device->iddevices }}" class="dz-remove ajax-delete-image">@lang('partials.remove_file')</a>
                    </div>
                  @endforeach
                @endif
                <div class="uploads-{{ $device->iddevices }}"></div>
              </div>
          </div>
        </div>

    </td>
</tr>
@endif
