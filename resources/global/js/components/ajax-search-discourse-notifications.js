// API call to current site - check for notifications
function ajaxSearchNotifications() {
  // $base_url = window.location.host;

  $('.notification-menu-items').hide();
  $('.toggle-notifications-menu .bell-icon-active').hide();

  $url = process.env.MIX_APP_URL + '/test/discourse/notifications';

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
      console.log('Success: connected to Discourse.');

      // Response failed
      if (response.message == 'failed') {
        console.log('Success: failed to find any new notifications.');
        return false;
      }

      // If notifications exist then we can create a cookie
      var $notifications = response.notifications;

      if (Object.keys($notifications).length > 0) {
        console.log('Success: notifications found on Discourse.');

        $('.notification-menu-items').css('display', '');
        $('.toggle-notifications-menu .bell-icon-active').css('display', '');

        $.each($notifications, function(index, $notification) {
          $('.notification-menu-items').append(
            $('<li>').append(
              $('<a>').attr('href', process.env.MIX_APP_URL + '/notifications/' + $notification.id).text($notification.data.title)
            ).attr('class', 'notifcation-text')
          );
        });
      }
    },
  });
}

ajaxSearchNotifications();
