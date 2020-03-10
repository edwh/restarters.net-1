// API call to current site - check for user authenticated
function checkAuth() {
  $url = 'https://test-restarters.rstrt.org' + '/test/check-auth';

  $notifications_list_item = $('.notifications-list-item').hide();
  $auth_menu_items = $('.auth-menu-items').hide();

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

      if (response.authenticated == true) {
        if ($notifications_list_item.length) {
          $notifications_list_item.show();
        }

        if ($auth_list_item.length) {
          $auth_menu_items.show();
        }
      } else {
        $auth_list_item.find('a').attr('href', window.location.origin + '/');
      }
    },
  });
}

checkAuth();
