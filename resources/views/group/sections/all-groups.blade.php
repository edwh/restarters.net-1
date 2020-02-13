<section class="table-section py-30" id="all-groups">
  <p class="mb-30">There are <span class="font-weight-bold">{{ $groups_count }} groups</span></p>

  {{-- TODO: Open filters collapse --}}
  <input type="hidden" name="sort_direction" value="{{ $sort_direction }}" class="sr-only" />
  <input type="radio" name="sort_column" value="name" @if( $sort_column == 'name' ) checked @endif id="label-name" class="sr-only" />
  <input type="radio" name="sort_column" value="distance" @if( $sort_column == 'distance' ) checked @endif id="label-location" class="sr-only" />
  <input type="radio" name="sort_column" value="hosts" @if( $sort_column == 'hosts' ) checked @endif id="label-hosts" class="sr-only">
  <input type="radio" name="sort_column" value="restarters" @if( $sort_column == 'restarters' ) checked @endif id="label-restarters" class="sr-only" />
  <input type="radio" name="sort_column" value="upcoming_event" @if( $sort_column == 'upcoming_event' ) checked @endif id="label-upcoming_event" class="sr-only" />
  <input type="radio" name="sort_column" value="created_at" @if( $sort_column == 'created_at' ) checked @endif id="label-created" class="sr-only" />

  <div class="d-md-block collapse show" id="collapseSearchFilters">
    <div class="flex-dynamic-row mb-30">
      <div class="flex-dynamic">
        <label for="name" class="sr-only">@lang('groups.groups_name'):</label>
        @if(isset($name))
          <input type="text" name="name" class="form-control" placeholder="@lang('groups.search_name')" value="{{ $name }}"/>
        @else
          <input type="text" name="name" class="form-control" placeholder="@lang('groups.search_name')"/>
        @endif
      </div>

      <div class="flex-dynamic">
        @if( FixometerHelper::hasRole(Auth::user(), 'Administrator'))
          <label for="tags" class="sr-only">@lang('groups.group_tag'):</label>
          <div class="form-control form-control__select">
            <select id="tags" name="tags[]" class="form-control select2-tags-placeholder" multiple data-live-search="true" title="Choose group tags...">
              @foreach ($all_group_tags as $group_tag)
                @if(isset($selected_tags) && in_array($group_tag->id, $selected_tags))
                  <option value="{{ $group_tag->id }}" selected>{{ $group_tag->tag_name }}</option>
                @else
                  <option value="{{ $group_tag->id }}">{{ $group_tag->tag_name }}</option>
                @endif
              @endforeach
            </select>
          </div>
        @endif
      </div>

      <div class="flex-dynamic">
        <label for="location" class="sr-only">@lang('groups.group_town-city'):</label>
        @if(isset($location))
          <input type="text" name="location" class="form-control" placeholder="@lang('groups.town-city-placeholder')" value="{{ $location }}"/>
        @else
          <input type="text" name="location" class="form-control" placeholder="@lang('groups.town-city-placeholder')"/>
        @endif
      </div>

      <div class="flex-dynamic">
        <label for="country" class="sr-only">@lang('groups.group_country'):</label>
        <div class="form-control form-control__select">
          <select id="country" name="country" class="field select2-countries">
            <option value=""></option>
            @foreach (FixometerHelper::getAllCountries() as $country_code => $country_name)
              @if( isset($selected_country) && $country_name == $selected_country )
                <option selected value="{{ $country_name }}">{{ $country_name }}</option>
              @else
                <option value="{{ $country_name }}">{{ $country_name }}</option>
              @endif
            @endforeach
          </select>
        </div>
      </div>

      <div class="">
        <button type="submit" name="button" class="btn btn-sm btn-primary">
          @include('svgs.fixometer.search_ico')
        </button>
      </div>
    </div>
  </div>

  <div class="d-block d-md-none text-right mt-10">
    <a class="collapse-plus-and-minus-controller" data-toggle="collapse" href="#collapseSearchFilters" aria-expanded="true" aria-controls="collapseSearchFilters">
      Close Filters
    </a>

    <hr class="m-0 hr-sm">
  </div>

  <div class="table-responsive">
    <table role="table" class="table table-striped table-hover" id="sort-table">
      @include('partials.tables.head-groups')

      <tbody>
        @if( ! $groups->isEmpty() )
          @foreach ($groups as $group)
            @include('partials.tables.row-groups')
          @endforeach
        @else
          <tr>
            <td colspan="13" align="center" class="p-3">There are no groups</td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>

  <div class="d-flex justify-content-center">
    <nav aria-label="Page navigation example">
      {{-- Custom pagination view --}}
      <ul class="pagination">
        @include('pagination', [
          'paginator' => $groups->appends(request()->input()),
          'onEachSide' => 4
        ])
      </ul>
    </nav>
  </div>
</section>
