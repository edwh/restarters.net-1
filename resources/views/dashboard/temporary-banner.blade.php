<div class="row row-compressed">
    <div class="col">
        @if ( is_null(Cookie::get("information-alert-dismissed-faultcat")) && Auth::check() )

            <div class="alert alert-secondary information-alert alert-dismissible fade show " role="alert" id="createevents2020">
              <div class="d-sm-flex flex-row justify-content-between align-items-center">
                <div class="action-text-left float-left d-flex flex-row">
                    <span class="icon my-auto d-none">@include('partials.svg-icons.calendar-icon-lg')</span>
                    <div class="action-text mb-0">
                        <div class='mb-2'>
                          <span class='badge badge-success'>NEW!</span>
                          <strong>Get involved with community repair data with FaultCat! 😺</strong>
                        </div>
                        <p>Help categorise the faults we've seen in computers with a simple online task.  <a href="/faultcat">Play here</a> or <a href="{{{ env('DISCOURSE_URL')}}}/session/sso?return_path={{{ env('DISCOURSE_URL') }}}/t/get-involved-in-repair-data-with-faultcat/2315">learn more</a>.
                        </p>
                    </div>
                </div>

                <div class="float-right mt-3 mt-sm-0">
                    @php( $user = Auth::user() )
                    <a href='/faultcat' class='btn btn-md btn-primary btn-block' title=''>Let's play</a>
                    <button type="button" class="close set-dismissed-cookie float-none ml-2" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
              </div>
            </div>

        @endif

    </div>
</div>
