@extends('layouts.app')
@section('content')
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="d-flex justify-content-between">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{{ route('dashboard') }}}">FIXOMETER</a></li>
              <li class="breadcrumb-item active" aria-current="page">@lang('profile.edit_profile')</li>
            </ol>
          </nav>
          <div class="">
            <a href="/profile" class="btn btn-primary btn-view">View profile</a>
          </div>
        </div>
      </div>
    </div>

    @if(session()->has('message'))
      <div class="alert alert-success col-lg-12">
        {{ session()->get('message') }}
      </div>
    @endif

    @if (session()->has('error'))
      <div class="alert alert-danger col-lg-12">
        {{ session()->get('error') }}
      </div>
    @endif

    <div class="row justify-content-center">
      <div class="col-lg-4 offset-lg-sidebar">
        <div class="list-group" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action active" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">Profile</a>
          <a class="list-group-item list-group-item-action" id="list-account-list" data-toggle="list" href="#list-account" role="tab" aria-controls="account">Account</a>
          <a class="list-group-item list-group-item-action" id="list-email-preferences-list" data-toggle="list" href="#list-email-preferences" role="tab" aria-controls="email-preferences">Email preferences</a>
        </div>
      </div>
      <div class="col-lg-8" aria-labelledby="list-profile-list">

        <!-- <aside id="basic-profile" class="edit-panel">
          <h4>@lang('profile.panel_title_1')</h4>
          <p>@lang('profile.panel_content_1')</p>
        </aside> -->

        <!-- <aside id="email-alerts" class="edit-panel">
          <h4>@lang('profile.panel_title_2')</h4>
          <p>@lang('profile.panel_content_2')</p>
        </aside> -->



        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">

            <div class="edit-panel">

              <div class="form-row">
                <div class="col-lg-6">
                  <h4>@lang('general.profile')</h4>
                  <p>@lang('general.profile_content')</p>
                </div>
              </div>
              <form action="/profile/edit-info" method="post">
                @csrf
                <div class="form-row">
                  <div class="form-group col-lg-6">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                  </div>

                  <div class="form-group col-lg-6">
                        <label for="country">@lang('registration.country'):<sup>*</sup></label>
                        <div class="form-control form-control__select">
                            <select id="country" name="country" required aria-required="true" class="field select2">
                                <option value=""></option>
                                @foreach (FixometerHelper::getAllCountries() as $key => $value)
                                  @if ($user->country == $key)
                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                  @else
                                    <option value="{{ $key }}">{{ $value }}</option>
                                  @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="invalid-feedback">@lang('registration.country_validation')</div>
                    </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-lg-6">
                    <label for="email">Email address:</label>
                    <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}">
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="townCity">Town/City:</label>
                    <input type="text" class="form-control" id="townCity" name="townCity" value="{{ $user->location }}">
                  </div>
                </div>
                <div class="form-row">

                  <div class="form-group col-lg-6">
                      <label for="age">Age:</label>
                      <div class="form-control form-control__select">
                          <select id="age" name="age" required aria-required="true" class="field select2">
                              @foreach(FixometerHelper::allAges() as $age)
                                @if ( $user->age == $age )
                                  <option value="{{ $age }}" selected>{{ $age }}</option>
                                @else
                                  <option value="{{ $age }}">{{ $age }}</option>
                                @endif
                              @endforeach
                          </select>
                      </div>
                      <div class="invalid-feedback">@lang('registration.age_validation')</div>
                  </div>

                  <div class="form-group col-lg-6">
                    <label for="gender">Gender:</label>
                    <input id="gender" class="form-control" name="gender" value="{{ $user->gender }}">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-lg-12">
                    <label for="biography">Your biography (optional):</label>
                    <textarea class="form-control" id="biography" name="biography" rows="8" cols="80">{{ $user->biography }}</textarea>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-lg-12">
                    <div class="d-flex justify-content-end">
                      <button type="submit" class="btn btn-primary">Save profile</button>
                    </div>
                  </div>
                </div>
              </form>

              </div>
            <!-- / edit-panel -->


            <div class="row row-end">

              <div class="col-lg-6 d-flex col-bottom">
                <div class="edit-panel">
                  <h4>@lang('general.repair_skills')</h4>
                  <p>@lang('general.repair_skills_content')</p>
                  <form action="/profile/edit-tags" method="post">

                    @csrf

                    <div class="form-group">
                      <label for="tags[]">@lang('general.your_repair_skills'):</label>
                      <div class="form-control form-control__select">
                        <select id="tags" name="tags[]" class="select2-tags" multiple>
                            @foreach( FixometerHelper::skillCategories() as $key => $skill_category )
                              <optgroup label="{{{ $skill_category }}}">
                                @foreach ($skills[$key] as $skill)
                                  @if ( !empty($user_skills) && in_array($skill->id, $user_skills))
                                    <option value="{{ $skill->id }}" selected>{{ $skill->skill_name }}</option>
                                  @else
                                    <option value="{{ $skill->id }}">{{ $skill->skill_name }}</option>
                                  @endif
                                @endforeach
                              </optgroup>
                            @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="form-row">
                      <div class="form-group col-lg-12">
                        <div class="d-flex justify-content-end">
                          <button type="submit" class="btn btn-primary">@lang('general.save_repair_skills')</button>
                        </div>
                      </div>
                    </div>

                  </form>

                </div>
                <!-- / edit-panel -->

              </div>

              <div class="col-lg-6 d-flex col-bottom">
                <div class="edit-panel">
                  <h4>@lang('general.change_photo')</h4>
                  <p>@lang('general.change_photo_text')</p>
                  <form action="/profile/edit-photo" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                      <div class="form-group col-lg-12">
                        <label for="profilePhoto">@lang('general.profile_picture'):</label>
                        <input type="file" class="form-control" id="profilePhoto" name="profilePhoto">
                        <!-- <input type="file" class="form-control file" name="profile"data-show-upload="false" data-show-caption="true"> -->
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-lg-12">
                        <div class="d-flex justify-content-end">
                          <button type="submit" class="btn btn-primary">@lang('general.change_photo')</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- / edit-panel -->

              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="list-account" role="tabpanel" aria-labelledby="list-account-list">

            <div class="edit-panel">

              <div class="form-row">
                <div class="col-lg-6">
                  <h4>@lang('auth.change_password')</h4>
                  <p>@lang('auth.change_password_text')</p>
                </div>
              </div>

              <form action="/profile/edit-password" method="post">
                @csrf
                <fieldset class="registration__offset2">
                  <div class="form-row">
                    <div class="form-group col-lg-6">
                      <label for="current-password">@lang('auth.current_password'):</label>
                      <input type="password" class="form-control" id="current-password" name="current-password">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-lg-6">
                      <label for="new-password">@lang('auth.new_password'):</label>
                      <input type="password" class="form-control" id="new-password" name="new-password">
                    </div>
                    <div class="form-group col-lg-6">
                      <label for="new-password-repeat">@lang('auth.new_repeat_password'):</label>
                      <input type="password" class="form-control" id="new-password-repeat" name="new-password-repeat">
                    </div>
                  </div>
                </fieldset>

                <div class="form-row">
                  <div class="form-group col-lg-12">
                    <div class="d-flex justify-content-end">
                      <button type="submit" class="btn btn-primary">@lang('auth.change_password')</button>
                    </div>
                  </div>
                </div>
              </form>


            </div>

            <form action="/user/soft-delete" method="post" id="delete-form">
              @csrf

              <div class="alert alert-danger alert-delete" role="alert">
                @lang('auth.delete_account_text')
                <button type="submit" class="btn btn-danger" id="delete-form-submit">
                @lang('auth.delete_account')
                </button>
              </div>

            </form>

          </div>
          <div class="tab-pane fade" id="list-email-preferences" role="tabpanel" aria-labelledby="list-email-preferences-list">

            <div class="edit-panel">

              <div class="form-row">
                <div class="col-lg-6">
                  <h4>@lang('general.email_alerts')</h4>
                  <p>@lang('general.email_alerts_text')</p>
                </div>
              </div>

              <form action="/profile/edit-preferences" method="post">
                  @csrf
                  <fieldset class="email-options">
                      <div class="form-check d-flex align-items-center justify-content-start">
                          @if( $user->newsletter == 1 )
                            <input class="checkbox-top form-check-input" type="checkbox" name="newsletter" id="newsletter" value="1" checked>
                          @else
                            <input class="checkbox-top form-check-input" type="checkbox" name="newsletter" id="newsletter" value="1">
                          @endif
                          <label class="form-check-label" for="newsletter">
                          @lang('general.email_alerts_pref1')
                      </label>
                      </div>
                      <div class="form-check d-flex align-items-center justify-content-start">
                          @if( $user->invites == 1 )
                            <input class="checkbox-top form-check-input" type="checkbox" name="invites" id="invites" value="1" checked>
                          @else
                            <input class="checkbox-top form-check-input" type="checkbox" name="invites" id="invites" value="1">
                          @endif
                          <label class="form-check-label" for="invites">
                          @lang('general.email_alerts_pref2')
                      </label>
                      </div>
                  </fieldset>

                  <div class="button-group row">
                      <div class="col-xl-9 d-flex align-items-center justify-content-start">
                          <a class="btn-preferences" href="{{ env('PLATFORM_COMMUNITY_URL') }}/u/{{ Auth::user()->username }}/preferences/emails">@lang('auth.set_preferences')</a>
                      </div>
                      <div class="col-xl-3 d-flex align-items-center justify-content-end">
                          <button class="btn btn-primary btn-save">@lang('auth.save_preferences')</button>
                      </div>
                  </div>

              </form>

            </div>

          </div>
        </div>

      </div>
      <div class="col-6">


      </div>
    </div>
  </div>
@endsection