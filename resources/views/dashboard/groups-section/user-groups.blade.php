<div class="card card-info-box mb-35">
  <div class="card-body pt-10">
    <div class="d-flex flex-column flex-lg-row align-items-center">
      <h2 class="mb-0 mr-30">
        <span class="d-none d-lg-block">@lang('dashboard.groups_box')</span>
        <span class="d-block d-lg-none">@lang('dashboard.groups_box_mobile')</span>
      </h2>

      <div class="mr-auto d-none d-lg-block">
        @include('svgs.group.group-doodle')
      </div>

      @if (! $new_groups->isEmpty() && $show_new_groups_count)
        <div class="call_to_action call_to_action-sticky-right">
          <div class="doodle-icon">
            @include('svgs.dashboard.arrow-right-doodle')
          </div>

          Newly added: {{ $new_groups->count() }} {{ str_plural('group', $new_groups->count()) }} in your area!
        </div>
      @endif
    </div>

    <hr class="hr-dashed mb-25 mt-10">

    @if (! $new_groups->isEmpty() && $show_new_groups_count)
      <div class="call_to_action d-block d-lg-none mb-25">
        <div class="doodle-icon">
          @include('svgs.dashboard.arrow-right-doodle')
        </div>

        Newly added: {{ $new_groups->count() }} {{ str_plural('group', $new_groups->count()) }} in your area!
      </div>
    @endif

    @if (! $user_groups->isEmpty())
      <div class="row">
        <div class="col-12 col-lg-6 mb-40 mb-lg-0 d-flex flex-column">
          <div class="fixed-height-100 mb-20">
            <b>
              @lang('dashboard.groups_group_chat_title')
            </b>

            <p class="card-text mb-0">
              @lang('dashboard.groups_group_chat_description')
            </p>
          </div>

          @if( ! $user_groups->isEmpty() )
            <div class="table-responsive mb-0">
              <table role="table" class="table table-hover table-border-rows mb-0">
                <tbody>
                  @php $take_3_groups = $user_groups->take(3); @endphp
                  @foreach ($take_3_groups as $group)
                    @include('partials.tables.row-group-small')
                  @endforeach
                </tbody>
              </table>
            </div>

            <a href="#" class="text-dark text-underlined ml-auto">
              <u>
                see all
              </u>
            </a>
          @endif
        </div>

        <div class="col-12 col-lg-6 d-flex flex-column">
          <div class="fixed-height-100 mb-20 d-flex flex-wrap flex-row align-items-start justify-content-between">
            <div class="">
              <b>
                @lang('dashboard.events_upcoming_title')
              </b>

              <p class="card-text mb-0">
                @lang('dashboard.events_upcoming_description')
              </p>
            </div>

            @if( FixometerHelper::userCanCreateEvents(Auth::user()) )
              <a href="/party/create" class="btn btn-primary btn-sm w-min-auto">
                Add
              </a>
            @endif
          </div>

          @if( ! $upcoming_events->isEmpty())
            <div class="table-responsive mb-0">
              <table role="table" class="table table-hover table-border-rows mb-0">
                <tbody>
                  @foreach ($upcoming_events as $event)
                    @include('partials.tables.row-event-small')
                  @endforeach
                </tbody>
              </table>
            </div>

            <a href="#" class="text-dark text-underlined ml-auto">
              <u>
                see all
              </u>
            </a>
          @elseif ( ! $user_upcoming_events->isEmpty())
            <div class="table-responsive mb-0">
              <table role="table" class="table table-hover table-border-rows mb-0">
                <tbody>
                  @foreach ($user_upcoming_events as $event)
                    @include('partials.tables.row-event-small')
                  @endforeach
                </tbody>
              </table>
            </div>

            <a href="#" class="text-dark text-underlined ml-auto">
              <u>
                see all
              </u>
            </a>
          @endif
        </div>
      </div>
    @endif
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="sendUrgentMessageModal" tabindex="-1" role="dialog" aria-labelledby="sendUrgentMessageLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Choose a group</h5>
        </div>
      <div class="modal-body">
        <div class="flex-dynamic-row">
          <div class="flex-dynamic mb-0">
            <label for="user_groups" class="sr-only">@lang('devices.group'):<</label>
            <div class="form-control form-control__select">
              <select id="user_groups" name="group" class="form-control select2-group group_discourse_slug" title="Choose group...">
                @if( ! $owned_groups->isEmpty() )
                  @foreach($owned_groups as $group)
                    @if ($group->discourse_slug == '')
                      @continue
                    @endif

                    <option value="{{ $group->discourse_slug }}">
                      {{ $group->name }}
                    </option>
                  @endforeach
                @endif
              </select>
            </div>
          </div>

          <a href="javascript:{}" data-initial-url="{{ config('restarters.discourse.base_url')."/g/" }}" class="btn btn-primary w-min-auto redirectToIntended">
            @lang('dashboard.compose')
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
