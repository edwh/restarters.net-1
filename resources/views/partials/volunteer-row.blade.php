@php( $user = $volunteer->eventUser )
@php( $user_skills = $user->userSkills )

<tr class="volunteer-{{ $volunteer->user }}">
  <td class="table-cell-icon">
    @php( $path = $user->getProfile($user->id)->path )
    @if ( is_null($path) )
      <img src="{{ asset('/images/placeholder-avatar.png') }}" alt="Placeholder avatar" class="rounded">
    @else
      <img src="{{ asset('/uploads/thumbnail_' . $path) }}" alt="{{ $user->name }}'s avatar" class="rounded">
    @endif
  </td>
  <td>
    <a href="/profile/{{ $user->id }}">
      {{ $user->name }}
      @if ( $volunteer->role == 3 )
        <span class="badge badge-primary">Host</span>
      @endif
    </a>
  </td>
  <td>
    @foreach( $user_skills as $skill )
       {{{ $skill->skillName->skill_name }}}<br>
    @endforeach
  </td>
  @if ( ( FixometerHelper::hasRole(Auth::user(), 'Host') && FixometerHelper::userHasEditPartyPermission($formdata->id, Auth::user()->id) ) || FixometerHelper::hasRole(Auth::user(), 'Administrator'))
    <td>
      <a href="#" class="users-list__remove js-remove" data-remove-volunteer="{{ $volunteer->user }}" data-event-id="{{ $volunteer->event }}" data-type="{{{ $type }}}">Remove volunteer</a>
    </td>
  @endif
</tr>
