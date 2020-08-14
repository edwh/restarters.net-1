<section class="table-section py-30" id="user-groups">

  @if (\Session::has('success'))
    @include('partials.alerts.alert-danger', [
      'text' => \Session::get('success'),
      'class' => 'mb-40'
    ])
  @endif

  <div class="row border-between mt-0 mb-40">
    <div class="col-12 col-lg-4 d-md-block collapseReadMore collapse show" id="collapseReadMore1">
      <b>
        We are a network of local repair groups from around the world.
      </b>
    </div>

    <div class="col-12 col-lg-4 d-md-block collapseReadMore collapse show" id="collapseReadMore2">
      <p class="mb-0">Groups you create or follow appear below for quick access.</p>
    </div>

    <div class="col-12 col-lg-4">
      <p class="mb-0">
        If you can't see any here yet, why not <a href="#pane-B" data-toggle="tab" role="tab" aria-selected="true" class="btn-link">follow your nearest group</a> to hear about their upcoming repair events?
      </p>
    </div>
  </div>

  <div class="d-block d-md-none text-right">
    <a class="collapse-plus-and-minus-controller" data-close-text="Read More" data-open-text="Read Less" data-toggle="collapse" href=".collapseReadMore" aria-expanded="true" aria-controls="collapseReadMore1 collapseReadMore2">
      Read Less
    </a>

    <hr class="m-0 hr-sm">
  </div>

  <div class="table-responsive">
    <table role="table" class="table table-striped table-hover">
      @include('partials.tables.head-your-groups')
      <tbody>
        @if( ! $your_groups->isEmpty() )
          @foreach ($your_groups as $group)
            @include('partials.tables.row-your-groups')
          @endforeach
        @else
          <tr>
            <td colspan="13" align="center" class="p-3">
              @lang('groups.not_joined_a_group')
              @if( FixometerHelper::hasRole(Auth::user(), 'Administrator') || FixometerHelper::hasRole(Auth::user(), 'Host') )
                <br><a href="/group/all">See all groups</a>
              @endif
            </td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>

</section>
