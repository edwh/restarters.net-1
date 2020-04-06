// API call to current site - check for user authenticated
function checkAuth() {
  $url = process.env.MIX_APP_URL + '/test/check-auth';

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
          $.each( response.menu.reporting, function( key, value ) {
            var spacer_condition = key.includes('spacer');

            var header_condition = key.includes('header');

            if (header_condition) {
              $main_navigation_dropdown.append(
                $('<li>').attr('class', 'dropdown-menu-header').text(value)
              );
            } else if (spacer_condition) {
              $main_navigation_dropdown.append(
                $('<li>').attr('class', 'dropdown-spacer')
              );
            } else {
              $main_navigation_dropdown.append(
                $('<li>').append(
                  $('<a>').attr('href', value).text(key)
                )
              );
            }
          });

          $('.regular-user-svg').addClass('d-none');
          $('.authenticated-user-svg').removeClass('d-none');
        }

        // IS ADMIN - User Toggler dropdown menu
        if (response.is_admin) {
          $.each( response.menu.user, function( key, value ) {
            var spacer_condition = key.includes('spacer');

            var header_condition = key.includes('header');

            if (header_condition) {
              $auth_menu_items.append(
                $('<li>').attr('class', 'dropdown-menu-header').text(value)
              );
            } else if (spacer_condition) {
              $auth_menu_items.append(
                $('<li>').attr('class', 'dropdown-spacer')
              );
            } else {
              $auth_menu_items.append(
                $('<li>').append(
                  $('<a>').attr('href', value).text(key)
                )
              );
            }
          });
        }

        if ($notifications_list_item.length) {
          $notifications_list_item.css('display','');
        }

        if ($auth_list_item.length) {
          $auth_menu_items.addClass('dropdown-menu-items');
          $auth_menu_items.css('display','');
        }
      } else {
        $auth_list_item.find('a').attr('href', process.env.MIX_APP_URL);
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
