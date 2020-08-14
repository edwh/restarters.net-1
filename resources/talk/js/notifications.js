function ajaxSearchNotifications() {
  // $base_url = window.location.host;

  var html = '<a href="#" class="toggle-notifications-menu">' +
  '<svg class="notification-bell"><span class="bell-icon-active" style="display: none;"></svg></a></span>';

  $('.notification-icon').append(html);

  var notification_text = '<ul class="dropdown-menu-items notification-menu-items"></ul>';
  $('.d-header-icons').append(notification_text);

  $('.notification-menu-items').hide();
  $('.toggle-notifications-menu .bell-icon-active').hide();

  var $url = 'https://restarters.dev' + '/test/discourse/notifications';

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

        // $('.notification-menu-items').show();
        $('.toggle-notifications-menu .bell-icon-active').show();

        $.each($notifications, function(index, $notification) {
          $('.notification-menu-items').append(
            $('<li>').append(
              $('<a>').attr('href', 'https://restarters.dev' + '/notifications/' + $notification.id).attr('class', 'notification-link').text($notification.data.title)).attr('class', 'notifcation-text')
          );
        });
      } else {
        $('.notification-menu-items').append(
          $('<p class="admin-menu-header">').text('No notifications')
        );
      }
    },
  });
}

function goToNotification() {
  $(".notification-link").click(function(){
    document.location.href= $(this).attr('href');
  });
}
