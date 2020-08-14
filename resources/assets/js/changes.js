$('.slick-your-groups').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  dots: true,
  centerMode: true,
  focusOnSelect: true,
  arrows: false,
  infinite: true,
  centerPadding: '25',
});

//This will sort your array
function SortByName(a, b){
  var aName = a.name.toLowerCase();
  var bName = b.name.toLowerCase();
  return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
}

function searchEventsByGroup() {
  $group_id = $(".change-group :selected").val();

  if ($group_id == null) {
    return false;
  }

  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $("input[name='_token']").val()
    },
    type: 'GET',
    url: '/api/events/'+ $group_id,
    datatype: 'json',
    success: function(response) {
      $('.change-events option').remove();
      $events = JSON.parse(response.events)

      $.each($events, function($key, $event) {
        var data = {
            id: $event.id,
            text: $event.location
        };

        var newOption = new Option(data.text, data.id, false, false);
        $('.change-events').append(newOption).trigger('change');
      });

      console.log('Success: Found ' + $('.change-events option').length + ' events.');
    },
  });
}

$(document).ready(function() {

  searchEventsByGroup();

  require('./components/table.js');

  // Change controller for collapse text
  $('.collapse-plus-and-minus-controller').click(function() {
    $(this).text(function(i,old){
      return old == $(this).attr('data-close-text') ? $(this).attr('data-open-text') : $(this).attr('data-close-text');
    });
  });

  // Initialize tooltips
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });

  $('.redirectToIntended').click(function() {
    $prefix = $(this).attr('data-initial-url');

    location.href = $prefix + $('.group_discourse_slug').val() + '/messages/inbox/';
  });

  $('.change-group').on('change', function() {
    searchEventsByGroup();
  });

  $('.change-events').on('change', function() {
    $('.change-event-url').attr('href', '/party/view/' + $(this).val() + '#devicesSection');
  });
});
