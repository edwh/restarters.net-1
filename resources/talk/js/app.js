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
}, 1000);

setTimeout(function() {
  if (window.location.href.indexOf("messages") > -1) {
    var inbox_tab = document.querySelector('.inbox');
    inbox_tab.classList.add('active');
  } else {
    var forum_tab = document.querySelector('.forum');
    forum_tab.classList.add('active');
  }
}, 300);

function addActive(tab) {
  var alreadyActive = document.querySelector('.active');
  alreadyActive.classList.remove('active');
  tab.classList.add('active');
}

function toggleNotifications() {
  $('.notification-icon').click(function(e) {
    e.preventDefault();
    // If item is already active then close all.
    if ( $(this).hasClass('dropdown-active')) {
      $('.notification-icon').each(function() {
        $(this).removeClass('dropdown-active');
        $(this).parents().children('.dropdown-menu-items').hide();
      });

      return false;
    }

    // Show items.
    $('.toggle-notifications-menu').toggleClass('dropdown-active');
    $('.toggle-notifications-menu').parents().children('.dropdown-menu-items').toggle();
  });
}

function hamburgerMenu() {
  var html = "<div class='hamburger-dropdown-menu-items' style='display: none;'><li><a href='https://talk.restarters.net/about'> About</a></li><li><a href='https://talk.restarters.net/guidelines'>Guidelines</a></li><li><a href='https://talk.restarters.net/tos'>Terms of use</a></li><li><a href='https://talk.restarters.net/privacy'>Privacy</a></li><li><a href='https://talk.restarters.net/c/help' target='_blank' rel='noopener noreferrer'>Help &amp; Feedback</a></li><li><a href='https://therestartproject.org/faq' target='_blank' rel='noopener noreferrer'>FAQs</a></li><li><a href='https://therestartproject.org' target='_blank' rel='noopener noreferrer'>therestartproject.org</a></li></div>";
  $(html).insertAfter('.d-header-icons');

  $('.restarters-hamburger-toggle').click(function(e) {
    $('.toggle-hamburger-menu').toggleClass('dropdown-active');
    $('.hamburger-dropdown-menu-items').toggle();
  });
}

function userMenu() {
  var html = "<div class='user-dropdown-menu-items' style='display: none;'><li><a href='https://talk.restarters.net/about'> About</a></li><li><a href='https://talk.restarters.net/guidelines'>Guidelines</a></li><li><a href='https://talk.restarters.net/tos'>Terms of use</a></li><li><a href='https://talk.restarters.net/privacy'>Privacy</a></li><li><a href='https://talk.restarters.net/c/help' target='_blank' rel='noopener noreferrer'>Help &amp; Feedback</a></li><li><a href='https://therestartproject.org/faq' target='_blank' rel='noopener noreferrer'>FAQs</a></li><li><a href='https://therestartproject.org' target='_blank' rel='noopener noreferrer'>therestartproject.org</a></li></div>";
  $(html).insertAfter('.d-header-icons');

  $('.restarters-user-toggle').click(function(e) {
    $('.toggle-user-menu').toggleClass('dropdown-active');
    $('.user-dropdown-menu-items').toggle();
  });
}


setTimeout(function() {
  hamburgerMenu();
  userMenu();
  toggleNotifications();
  ajaxSearchNotifications();
}, 300);
