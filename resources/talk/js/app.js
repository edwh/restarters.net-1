setTimeout(function() {
  if( ! $('.ui-loaded').length ) {
    createUI();
    changeForumNavigation();
    activateSearch();
    isLoggedIn();
    checkAuth();
    defineClicks();

    $('body').addClass('ui-loaded');
  }
}, 300);

setTimeout(function() {
  var observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
      if (mutation.attributeName === "class") {
        checkAuth();
        defineClicks();
        var attributeValue = $(mutation.target).prop(mutation.attributeName);
        console.log("Class attribute changed to:", attributeValue); // expecting hide-menus
      }
    });
  });
  observer.observe(document.getElementsByClassName('d-header').item(0), {
    attributes: true
  });
}, 3000);

setTimeout(function() {
  if (window.location.href.indexOf("messages") > -1) {
    $('.forum-tabs .inbox').addClass('active');
  } else {
    $('.forum-tabs .forum').addClass('active');
  }

  $('.custom-header-links .talk').addClass('active');
}, 300);

function isLoggedIn() {
  if( ! $('.login-button').length ) {
    $('body').addClass('logged-in');
  }
}

function createUI() {
  if( ! $('.hamburger-dropdown-menu-items').length ) {
    var html = "<div class='hamburger-dropdown-menu-items' style='display: none;'><ul class='hamburger-dropdown-menu'></ul></div>";
    $(html).insertAfter('.d-header .wrap');
    console.log('al1 on');
  } else {
    console.log('al1 off');
  }

  if( ! $('.user-dropdown-menu-items').length) {
    var html = "<div class='user-dropdown-menu-items' style='display: none;'><ul class='user-dropdown-menu'></ul></div>";
    $(html).insertAfter('.d-header .wrap');
    console.log('al2 on');
  } else {
    console.log('al2 off');
  }
}

function addActive(tab) {
  $('.forum-tabs .active').removeClass('active');
  tab.classList.add('active');
}

function defineClicks() {
  $('.notification-icon').click(function(e) {
    e.preventDefault();
    $('a.dropdown-active').not('.toggle-notifications-menu').removeClass('dropdown-active');
    $('.user-dropdown-menu-items, .hamburger-dropdown-menu-items').hide();
    $('.toggle-notifications-menu').toggleClass('dropdown-active');
    $('.notification-menu-items').toggle();
  });

  $('.restarters-hamburger-toggle').click(function(e) {
    e.preventDefault();
    $('a.dropdown-active').not('.toggle-hamburger-menu').removeClass('dropdown-active');
    $('.user-dropdown-menu-items, .notification-menu-items').hide();
    $('.toggle-hamburger-menu').toggleClass('dropdown-active');
    $('.hamburger-dropdown-menu-items').toggle();
  });

  $('.restarters-user-toggle').click(function(e) {
    e.preventDefault();
    $('a.dropdown-active').not('.toggle-user-menu').removeClass('dropdown-active');
    $('.hamburger-dropdown-menu-items, .notification-menu-items').hide();
    $('.toggle-user-menu').toggleClass('dropdown-active');
    $('.user-dropdown-menu-items').toggle();
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

// setTimeout(function() {
//   var options = document.querySelectorAll(".messages-dropdown-123 option");
//   for(const option of options) {
//     const url = option.dataset.url;
//     const location = window.location.href;
//     const lastPart = location.substr(location.lastIndexOf('/') + 1);
//     if (lastPart == url) {
//       option.setAttribute("selected", "");
//       break;
//     }
//   }
// }, 500);
