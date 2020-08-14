@if (session('invites-feedback'))
  <ul class="alert alert-success list-unstyled">
    @foreach (session('invites-feedback') as $key => $message)
      <li>{!! $message !!}</li>
    @endforeach
  </ul>
@endif

@if (session('response'))
  @foreach (session('response') as $key => $message)
    <div class="alert alert-{{ $key }}">
      {{ $message }}
    </div>
  @endforeach
@endif

@if (\Session::has('success'))
  <div class="alert alert-success">
    {!! \Session::get('success') !!}
  </div>
@endif

@if (\Session::has('warning'))
  <div class="alert alert-warning">
    {!! \Session::get('warning') !!}
  </div>
@endif
