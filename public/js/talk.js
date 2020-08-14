// API call to current site - check for user authenticated

function checkAuth() {
  console.log('checking auth');
  var $url = 'https://restarters.dev' + '/test/check-auth';

  var $notifications_list_item = $('.notifications-list-item').hide();
  var $auth_menu_items = $('.user-dropdown-menu-items').hide();
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
      var $auth_list_item = $('.auth-list-item');

      var response = response.data;

      var html = "<div class='hamburger-dropdown-menu-items' style='display: none;'><ul class='hamburger-dropdown-menu'></ul></div>";
      $(html).insertAfter('.d-header-icons');

      var $main_navigation_dropdown = $('.hamburger-dropdown-menu');

      if (response.authenticated === true) {
        $('.d-header-icons').attr('style', 'display:inline-flex');
        $main_navigation_dropdown.attr('style', 'display:block');
        hamburgerMenu();
        //categoriesMenu();
        ajaxSearchNotifications();

        userMenu();

        if ($notifications_list_item.length) {
          $notifications_list_item.css('display','');
        }

        if(response.is_admin) {
          $('.toggle-hamburger-menu svg').removeClass('restarters-hamburger');
          $('.toggle-hamburger-menu svg').addClass('restarters-hamburger-admin');

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
        }

        if(response.menu) {
          $auth_menu_items = $('.user-dropdown-menu');
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
        hideHeaderIcons();
        $auth_list_item.find('a').attr('href', 'https://restarters.dev');
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

function userMenu() {
  var html = "<div class='user-dropdown-menu-items'><ul class='user-dropdown-menu'></ul></div>";
  $(html).insertAfter('.d-header-icons');

  $('.restarters-user-toggle').click(function(e) {
    e.preventDefault();
    $('a.dropdown-active').not('.toggle-user-menu').removeClass('dropdown-active');
    $('.hamburger-dropdown-menu-items').hide();
    $('.notification-menu-items').hide();
    $('.toggle-user-menu').toggleClass('dropdown-active');
    $('.user-dropdown-menu-items').toggle();
  });
}

setTimeout(function() {
  checkAuth();
  changeForumNavigation();
  activateSearch();
  toggleNotifications();
}, 300);

function hideHeaderIcons() {
    $('.d-header-icons').attr('style', 'display:none');
}

function navigateUrl(item) {
  if(item.value) {
    location.href = document.location.origin + item.value;
  }
}

setTimeout(function() {
  var options = document.querySelectorAll(".messages-dropdown-123 option");
  for(const option of options) {
    const url = option.dataset.url;
    const location = window.location.href;
    const lastPart = location.substr(location.lastIndexOf('/') + 1);
    if (lastPart == url) {
      option.setAttribute("selected", "");
      break;
    }
  }
}, 500);

setTimeout(function() {
  if (window.location.href.indexOf("messages") > -1) {
    var inbox_tab = document.querySelector('.inbox');
    inbox_tab.classList.add('active');
  } else {
    var forum_tab = document.querySelector('.forum');
    forum_tab.classList.add('active');
  }

  $('.custom-header-links .talk').addClass('active');
}, 300);

function addActive(tab) {
  var alreadyActive = document.querySelector('.active');
  alreadyActive.classList.remove('active');
  tab.classList.add('active');
}

function toggleNotifications() {
  $('.notification-icon').click(function(e) {
    e.preventDefault();
    $('a.dropdown-active').not('.toggle-notifications-menu').removeClass('dropdown-active');
    $('.user-dropdown-menu-items').hide();
    $('.hamburger-dropdown-menu-items').hide();
    $('.toggle-notifications-menu').toggleClass('dropdown-active');
    $('.notification-menu-items').toggle();
  });
}

function hamburgerMenu() {
  $('.restarters-hamburger-toggle').click(function(e) {
    e.preventDefault();
    $('a.dropdown-active').not('.toggle-hamburger-menu').removeClass('dropdown-active');
    $('.user-dropdown-menu-items').hide();
    $('.notification-menu-items').hide();
    $('.toggle-hamburger-menu').toggleClass('dropdown-active');
    $('.hamburger-dropdown-menu-items').toggle();
  });
}

function changeForumNavigation() {
  $('#create-topic').addClass('d-none');
  $('#create-topic .d-button-label').text('New Topic');
  $('#create-topic').removeClass('d-none');

  var text = "<p class='forum-nav-text'><strong>A place to discuss all things repair: advice, activism, and more.</strong> Join in! Anyone can post a topic.</p>";
  $(text).insertAfter("#create-topic");
}

function activateSearch() {
  $('#search-button-123').click(function() {
    $('#search-button').trigger('click');
  });

  $(document).mouseup(function(e)
  {
      var container = $(".search-menu");
      if (!container.is(e.target) && container.has(e.target).length === 0)
      {
          container.hide();
      }
  });
}

// function categoriesMenu() {
//   $('.category-breadcrumb').remove();
//   var dropdown = "<div class='talk-categories'><span>Latest topics <svg xmlns='http://www.w3.org/2000/svg' width='16.086' height='8.794' viewBox='0 0 16.086 8.794'><path d='M7.263 8.359a1.692 1.692 0 0 0 2.265 0L15.681 2.5A1.4 1.4 0 1 0 13.695.528L8.563 5.367a.35.35 0 0 1-.461 0L2.325.347A1.402 1.402 0 0 0 .48 2.458z' data-name='Path 125'/></svg></span><ul class='talk-menu' style='display: none;'><li><a href='/categories'>Topic Categories</a></li><li><a href='/latest'>Latest Forum Topics</a></li><li><a href='/c/help'>Help & Feedback</a></li><li><a href='/g?type=my'>My Groups</a></li><li><a href='/c/help/user-guides'>User Guides</a></li><li><a href='/c/local-chat'>Group Chat</a></li></ul></div>";
//   $(dropdown).insertBefore("#create-topic");
//
//   $('.talk-categories').click(function() {
//     $('.talk-menu').toggle();
//   });
// }

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
