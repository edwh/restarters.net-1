<div class="alert alert-danger alert-custom alert-dismissible fade show mb-30 {{ $class }}" role="alert">
  <div class="row no-gutters align-items-center">
    <div class="col-2 d-none d-md-block">
      <div class="mr-3 mb-2 mb-lg-0">
        @include('svgs.alerts.alert-doodle')
      </div>
    </div>

    <div class="col-10">
      <p class="mb-0">
        {!! $text !!}
      </p>
    </div>
  </div>

  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
