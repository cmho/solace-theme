export default {
  init() {
    $('.dots i.fa-circle').on('click', function() {
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

    function updateHealth () {
      var amt = parseInt($('input[name="stamina"]').val()) + 5;
      var str = "";
      for (var i = 0; i < amt; i++) {
        str += "<i class='far fa-square'></i>";
      }
      $('#health').html(str);
    }

    function updateSpeed() {
      var spd = parseInt($('input[name="dexterity"]')) + parseInt($('input[name="strength"]')) + 5;
      $('input[name="speed"]').val(spd);
    }

    function updateInitiative() {
      var ini = parseInt($('input[name="dexterity"]')) + parseInt($('input[name="composure"]'));
      $('input[name="initiative"]').val(ini);
    }

    function updateDefense() {
      var def = Math.min(parseInt($('input[name="wits"]')), parseInt($('input[name="dexterity"]'))) + parseInt($('input[name="athletics"]'));
      $('input[name="defense"]').val(def);
    }

    $('input[name="composure"]').on('change', function() {
      updateWillpower();
      updateInitiative();
    });

    $('input[name="resolve"]').on('change', function() {
      updateWillpower();
    });

    $('input[name="stamina"]').on('change', function() {
      updateHealth();
    });

    $('input[name="wits"]').on('change', function() {
      updateDefense();
    });

    $('input[name="dexterity"]').on('change', function() {
      updateDefense();
      updateSpeed();
      updateInitiative();
    });

    $('input[name="strength"]').on('change', function() {
      updateSpeed();
    });

    $('input[name="athletics"]').on('change', function() {
      updateDefense();
    });
  },
  finalize() {

  },
};
