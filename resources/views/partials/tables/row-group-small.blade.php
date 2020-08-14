<tr>
  {{-- ICON --}}
  <td class="table-cell-icon text-center" colspan="1">
    @php( $group_image = $group->groupImage )
    @if( is_object($group_image) && is_object($group_image->image) )
      <img class="mx-auto" src="{{ $group_image->image->asset_path }}" alt="{{{ $group->name }}}">
    @else
      <img class="mx-auto" src="{{ asset('/images/placeholder-avatar.png') }}" alt="{{{ $group->name }}}">
    @endif
  </td>

  {{-- NAME --}}
  <td colspan="1">
    <a href="/group/view/{{{ $group->idgroups }}}" title="edit group">
      {{{ $group->name }}}
    </a>
  </td>
</tr>
