@if (Auth::check())
    @include('layouts.header')
@else
    @include('layouts.header_plain')
@endif

@yield('content')

<section class="errors">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-12 align-self-center">
                <h1>You do not have permission to view this page.</h1>

                <img class="rounded img-fluid" src="/images/broken-toaster.png" alt="Woman with broken toaster" />

                <h2>
                    Please let us know if you think that you should have permission and that this is an error.
                </h2>
                <p>
                    You can report the issue by sending an email to <a href="mailto:community@therestartproject.org">community@therestartproject.org</a>, or by posting in the <a href="https://talk.restarters.net/c/restarters-dev">restarters.net development forum</a>.
                </p>
                <p>
                    Please include the following details in your bug report:
                </p>
                <ul>
                    @if (Auth::check())
                        <li><strong>User</strong>: {{ Auth::user()->name }}</li>
                    @endif
                    <li><strong>Error</strong>:  403</li> 
                    <li><strong>Time</strong>: {{ now() }}</li>
                    <li><strong>URL</strong>: {{ Request::url() }}</li>
                    <li><strong>Previous URL</strong>: {{ URL::previous() }}</li>
                </ul>

                <p>Thanks!</p>

                @if (Auth::check())
                <p>
                    In the meantime, you could try going <a href="{{ URL::previous() }}">back</a>, or returning to the <a href="/dashboard">dashboard</a>.
                </p>
                <p>
                    If you continue to get an error, you could try <a href="/logout">logging out</a> and logging back in again.
                </p>
                @endif

            </div>
        </div>
    </div>

</section>

@include('layouts.footer')