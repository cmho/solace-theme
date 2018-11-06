export default {
  init() {
    // JavaScript to be fired on all pages
    $('.dots i.fa-circle').on('click', function () {
      $(this).nextAll('i.fa-circle').removeClass('fas').addClass('far');
      if ($(this).hasClass('far')) {
        $(this).addClass('fas').removeClass('far');
        $(this).prevAll('i.fa-circle').removeClass('far').addClass('fas');
      } else if ($(this).hasClass('fas') && $(this).nextAll('.fas').length == 0) {
        $(this).removeClass('fas').addClass('far');
      } else {
        $(this).nextAll('.fas').removeClass('fas').addClass('far');
      }
      var count = $(this).parent('.dots').find('.fas').length;
      $(this).parent('.dots').find('input').val(count);
      $(this).parent('.dots').find('input').change();
    });

    function updateWillpower() {
      var amt = parseInt($('input[name="composure"]').val()) + parseInt($('input[name="resolve"]').val());
      var str = "";
      for (var i = 0; i < amt; i++) {
        str += "<i class='far fa-square'></i>";
      }
      $('#willpower').html(str);
    }

    function updateHealth() {
      var amt = parseInt($('input[name="stamina"]').val()) + 5;
      var str = "";
      for (var i = 0; i < amt; i++) {
        str += "<i class='far fa-square'></i>";
      }
      $('#health').html(str);
    }

    function updateSpeed() {
      var spd = parseInt($('input[name="dexterity"]').val()) + parseInt($('input[name="strength"]').val()) + 5;
      $('input[name="speed"]').val(spd);
    }

    function updateInitiative() {
      var ini = parseInt($('input[name="dexterity"]').val()) + parseInt($('input[name="composure"]').val());
      $('input[name="initiative_mod"]').val(ini);
    }

    function updateDefense() {
      var def = Math.min(parseInt($('input[name="wits"]').val()), parseInt($('input[name="dexterity"]').val())) + parseInt($('input[name="athletics"]').val());
      $('input[name="defense"]').val(def);
    }

    $('input[name="composure"]').on('change', function () {
      updateWillpower();
      updateInitiative();
    });

    $('input[name="resolve"]').on('change', function () {
      updateWillpower();
    });

    $('input[name="stamina"]').on('change', function () {
      updateHealth();
    });

    $('input[name="wits"]').on('change', function () {
      updateDefense();
    });

    $('input[name="dexterity"]').on('change', function () {
      updateDefense();
      updateSpeed();
      updateInitiative();
    });

    $('input[name="strength"]').on('change', function () {
      updateSpeed();
    });

    $('input[name="athletics"]').on('change', function () {
      updateDefense();
    });

    $('#add-merit').on('click', function () {
      var merit = parseInt($('#merits option:selected').first().val());
      $.ajax({
        url: ajaxurl,
        method: 'POST',
        data: {
          id: merit,
          action: 'get_merit_info',
        },
        success: function (data) {
          var newNum;
          if ($('ul.merits li').length > 0) {
            var matches = $('ul.merits li').last().attr('name').match(/merits\[([0-9]+)\]/);
            newNum = parseInt(matches)+1;
          } else {
            newNum = 0;
          }
          var newItem = "<li>" + data.name + " <i class='fas fa-pencil-alt'></i><i class='fas fa-trash'></i><div class='description'></div><input type='hidden' name='merits[" + newNum + "][\"merit\"]' value='" + data.id + "' /><input type='hidden' name='merits[" + newNum + "][\"rating\"]' value='" + data.ratings[0] + "' /><input type='hidden' name='merits[" + newNum + "][\"specification\"]' value='' /><input type='hidden' name='merits[" + newNum + "][\"description\"]' value='' /></li>";
          $('ul.merits').append(newItem);
          $('[name="merits"]').val($('ul.merits li').length);
        },
      })
    });

    $('.merits').on('click', '.fa-pencil-alt', function () {

    });

    $('.merits').on('click', '.fa-trash', function () {
      var yn = confirm('Are you sure you want to delete this merit?');
      if (yn) {
        $(this).parents('li').detach();
        $('[name="merits"]').val($('ul.merits li').length);
      }
    });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
