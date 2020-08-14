<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }} @hasSection('title')- @yield('title')@endif</title>

    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('global/css/app.css') }}" rel="stylesheet">

    @yield('extra-css')

    <!-- Cookie banner with fine-grained opt-in -->
    <script src="{{ asset('js/gdpr-cookie-notice.js') }}"></script>
    <!-- Check to see if visitor has opted in to analytics cookies -->
    <script>
    window.restarters = {};
    restarters.cookie_domain = '{{ env('SESSION_DOMAIN') }}';
    var gdprCookiesCheck = Cookies;
    var gdprCurrentCookiesSelection = gdprCookiesCheck.getJSON('gdprcookienotice');
    restarters.analyticsCookieEnabled = (typeof gdprCurrentCookiesSelection !== 'undefined' && gdprCurrentCookiesSelection['analytics']);
    </script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    @if( ! empty( env('GOOGLE_ANALYTICS_TRACKING_ID')))
      <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GOOGLE_ANALYTICS_TRACKING_ID') }}"></script>
      <script>
      if (restarters.analyticsCookieEnabled) {
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '{{ env('GOOGLE_ANALYTICS_TRACKING_ID') }}');

        <!-- Google Tag Manager -->
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src= 'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
      })(window,document,'script','dataLayer', '{{ env('GOOGLE_TAG_MANAGER_ID') }}');
      <!-- End Google Tag Manager -->
    }
    </script>
  @endif
</head>
<body>

  {{-- Start Navigation --}}
  <nav class="nav-wrapper">

    {{-- Logo --}}
    <a href="{{ route('home') }}" class="icon-brand">
      <div class="d-none d-md-block">
        @include('includes/logo')
      </div>

      <div class="d-dlock d-md-none">
        @include('includes/logo-plain')
      </div>
    </a>

    {{-- Left side of the Navigation --}}
    <ul class="nav-left">
      <li>
        <a href="{{ env('DISCOURSE_URL')."/login" }}" rel="noopener noreferrer">
          @include('svgs/navigation/talk-icon')
          <span>@lang('general.menu_discourse')</span>
        </a>
      </li>

      <li class="@if(str_contains(url()->current(), route('devices'))) active @endif">
        <a href="{{ route('devices') }}">
          @include('svgs/navigation/drill-icon')
          <span>FIXOMETER</span>
        </a>
      </li>

      <li class="@if(str_contains(url()->current(), route('events'))) active @endif">
        <a href="{{ route('events') }}">
          @include('svgs/navigation/events-icon')
          <span>EVENTS</span>
        </a>
      </li>

      <li class="@if(str_contains(url()->current(), route('groups'))) active @endif">
        <a href="{{ route('groups') }}">
          @include('svgs/navigation/groups-icon')
          <span>GROUPS</span>
        </a>
      </li>

      <li>
        <a href="{{ config('restarters.wiki.base_url') }}" rel="noopener noreferrer">
          @include('svgs/navigation/wiki-icon')
          <span>@lang('general.menu_wiki')</span>
        </a>
      </li>
    </ul>

    {{-- Right side of the Navigation --}}
    <ul class="nav-right">
      <li>

        {{-- Admin Icon --}}
        <a href="#" class="toggle-dropdown-menu">
          @if ( FixometerHelper::hasRole(Auth::user(), 'Administrator') || FixometerHelper::hasRole(Auth::user(), 'Host') )
            @include('svgs/navigation/admin-menu-bar-icon')
          @else
            @include('svgs/navigation/menu-bar-icon')
          @endif
        </a>

        <ul class="dropdown-menu-items xxs-center">
          @if ( FixometerHelper::hasRole(Auth::user(), 'Administrator') || FixometerHelper::hasRole(Auth::user(), 'Host') )
            <li class="dropdown-menu-header">
              Reporting
            </li>

            @if ( FixometerHelper::hasRole(Auth::user(), 'Administrator'))
              <li>
                <a href="{{ url('reporting/time-volunteered?a') }}">
                  @lang('general.time_reporting')
                </a>
              </li>
            @endif

            <li>
              <a href="{{ url('search') }}">
                @lang('general.party_reporting')
              </a>
            </li>

            <li class="dropdown-spacer">
            </li>
          @endif

          <li>
            <a href="@lang('general.about_page_url')">
              @lang('general.about_page')
            </a>
          </li>

          <li>
            <a href="@lang('general.guidelines_page_url')">
              @lang('general.guidelines_page')
            </a>
          </li>

          <li>
            <a href="@lang('general.terms_of_use_page_url')">
              @lang('general.terms_of_use_page')
            </a>
          </li>

          <li>
            <a href="@lang('general.privacy_page_url')">
              @lang('general.privacy_page')
            </a>
          </li>

          <li>
            <a href="@lang('general.help_feedback_url')" target="_blank" rel="noopener noreferrer">
              @lang('general.menu_help_feedback')
            </a>
          </li>

          <li>
            <a href="@lang('general.faq_url')" target="_blank" rel="noopener noreferrer">
              @lang('general.menu_faq')
            </a>
          </li>

          <li>
            <a href="@lang('general.restartproject_url')" target="_blank" rel="noopener noreferrer">
              @lang('general.therestartproject')
            </a>
          </li>
        </ul>
      </li>

      <li>
        <a href="#" class="toggle-dropdown-menu toggle-notifications-menu">
          @include('svgs/navigation/bell-icon')
          <span class="bell-icon-active"></span>
        </a>

        <ul class="dropdown-menu-items notification-menu-items">
        </ul>
      </li>

      <li>
        <a href="#" class="toggle-dropdown-menu">
          @include('svgs/navigation/user-icon')
        </a>

        <ul class="dropdown-menu-items">
          <li>
            <a href="{{ url('profile/edit/'.Auth::user()->id) }}">
              @lang('general.profile')
            </a>
          </li>

          @if ( FixometerHelper::hasRole(Auth::user(), 'Administrator') )
            <li class="dropdown-spacer">
            </li>

            <li class="dropdown-menu-header">
              Administrator
            </li>

            <li>
              <a href="{{ route('brands') }}">
                Brands
              </a>
            </li>

            <li>
              <a href="{{ route('skills') }}">
                Skills
              </a>
            </li>

            <li>
              <a href="{{ route('tags') }}">
                Group tags
              </a>
            </li>

            <li>
              <a href="{{ route('category') }}">
                Categories
              </a>
            </li>

            <li>
              <a href="{{ route('users') }}">
                Users
              </a>
            </li>

            <li>
              <a href="{{ route('roles') }}">
                Roles
              </a>
            </li>

            @if ( FixometerHelper::hasPermission('verify-translation-access') )
              <li>
                <a href="{{ url('translations') }}">
                  Translations
                </a>
              </li>
            @endif
          @endif

          @if ( FixometerHelper::hasPermission('repair-directory') )
            <li>
              <a href="{{ config('restarters.repairdirectory.base_url') }}/admin" target="_blank" rel="noopener noreferrer">
                Repair Directory
              </a>
            </li>
          @endif

          <li class="dropdown-spacer">
          </li>

          <li>
            <a href="{{ url('logout') }}">
              @lang('general.logout')
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
</body>
