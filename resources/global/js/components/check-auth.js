// API call to current site - check for user authenticated
function checkAuth() {
  $url = 'https://test-restarters.rstrt.org' + '/test/check-auth';

  $notifications_list_item = $('.notifications-list-item').hide();
  $auth_menu_items = $('.auth-menu-items').hide();
  $auth_menu_items.removeClass('dropdown-menu-items');

  $.ajax({
    headers: {
      // 'X-CSRF-TOKEN': $("input[name='_token']").val(),
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    xhrFields: {
      withCredentials: true
    },
    type: 'GET',
    url: $url,
    datatype: 'json',
    success: function(response) {
      $auth_list_item = $('.auth-list-item');

      var response = response.data;

      $main_navigation_dropdown = $('.main-nav-dropdown');

      if (response.authenticated !== null && response.authenticated !== undefined) {

        // IS ADMIN - Toggler dropdown menu
        if (response.is_admin) {
          $main_navigation_dropdown.append(
            $('<li>').attr('class', 'dropdown-menu-header').text('Reporting')
          );

          $.each( response.menu.reporting, function( key, value ) {
            $main_navigation_dropdown.append(
              $('<li>').append(
                $('<a>').attr('href', value).text(key)
              )
            );
          });

          $main_navigation_dropdown.append(
            $('<li>').attr('class', 'dropdown-spacer')
          );

          $('.regular-user-svg').addClass('d-none');
          $('.authenticated-user-svg').removeClass('d-none');
        }

        // IS ADMIN - User Toggler dropdown menu
        if (response.is_admin) {
          console.log(true, 1);
          // TODO
        }

        if ($notifications_list_item.length) {
          $notifications_list_item.css('display','');
        }

        if ($auth_list_item.length) {
          $auth_menu_items.addClass('dropdown-menu-items');
          $auth_menu_items.css('display','');
        }

        if ($('.my-profile-url').length) {
          $('.my-profile-url').attr('href', response.edit_profile_link);
        }

      } else {
        $auth_list_item.find('a').attr('href', 'https://test-restarters.rstrt.org');
      }

      // Amend Main navigation dropdown links
      $.each( response.menu.general, function( key, value ) {
        $main_navigation_dropdown.append(
          $('<li>').append(
            $('<a>').attr('href', value).text(key)
          )
        );
      });
    },
  });
}

checkAuth();
