<div class="card card-info-box mb-30">
  <div class="card-body">
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

    <hr class="hr-dashed my-25">

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
        <div class="col-12 col-lg-6 mb-50 mb-md-0 d-flex flex-column">
          <b>
            Group chat
          </b>

          <p class="card-text mb-20">
            Catch up with your groups by clicking below.
            You can also <a href="#sendUrgrentMessageModal" data-toggle="modal" data-target="#sendUrgrentMessageModal">send an urgent message</a> to groups you host.
          </p>

          <!-- Modal -->
          <div class="modal fade" id="sendUrgrentMessageModal" tabindex="-1" role="dialog" aria-labelledby="sendUrgrentMessageLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-body">
                  <div class="flex-dynamic-row">
                    <div class="flex-dynamic mb-0">
                      <label for="user_groups" class="sr-only">@lang('devices.group'):<</label>
                      <div class="form-control form-control__select">
                        <select id="user_groups" name="group" class="form-control select2-group group_discourse_slug" title="Choose group...">
                          @if( ! $owned_groups->isEmpty() )
                            @foreach($owned_groups as $group)
                              <option value="{{ $group->discourse_slug }}">
                                {{ $group->name }}
                              </option>
                            @endforeach
                          @endif
                        </select>
                      </div>
                    </div>

                    <a href="javascript:{}" data-initial-url="{{ env('DISCOURSE_URL')."/g/" }}" class="btn btn-primary w-min-auto redirectToIntended">
                      Send
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          @if( ! $user_groups->isEmpty() )
            <div class="table-responsive mb-0 mt-auto">
              <table role="table" class="table table-hover mb-0">
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
          <div class="d-flex flex-wrap flex-row align-items-center justify-content-between mb-20">
            <div class="">
              <b>
                Upcoming events
              </b>

              <p class="card-text mb-0">
                Your groups' upcoming events:
              </p>
            </div>

            @if( FixometerHelper::userCanCreateEvents(Auth::user()) )
              <a href="/party/create" class="btn btn-primary btn-sm w-min-auto">
                Add
              </a>
            @endif
          </div>

          @if( ! $upcoming_events->isEmpty() )
            <div class="table-responsive mb-0 mt-auto">
              <table role="table" class="table table-hover mb-0">
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
          @endif
        </div>
      </div>
    @endif
  </div>
</div>
