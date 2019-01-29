export default {
  init() {
    $('.health').on('click', 'a.fa-stack', function (e) {
      e.preventDefault();
      var $indicator = $(this).children('.indicator').first();
      if ($indicator.hasClass('fa-slash')) {
        $indicator.removeClass('fa-slash').addClass('fa-times');
      } else if ($indicator.hasClass('fa-times')) {
        $indicator.removeClass('fa-times').addClass('fa-asterisk');
      } else if ($indicator.hasClass('fa-asterisk')) {
        $indicator.removeClass('fa-asterisk');
      } else {
        $indicator.addClass('fa-slash');
      }

      var bashing = $('div .fa-slash').length;
      var lethal = $('div .fa-times').length;
      var agg = $('div .fa-asterisk').length;

      $(this).parent('.health').find('span').text(bashing + ' bashing, ' + lethal + ' lethal, ' + agg + ' aggravated');

      var current_health = '';
      $(this).parent('.health').find('a .indicator').each(function() {
        if ($(this).hasClass('fa-slash')) {
          current_health += '1';
        } else if ($(this).hasClass('fa-times')) {
          current_health += '2';
        } else if ($(this).hasClass('fa-asterisk')) {
          current_health += '3';
        } else {
          current_health += '0';
        }
      });
      $(this).parent('.health').attr('data-health', current_health);

      var character = parseInt($(this).parents('li').data('character'));

      $.ajax({
        url: ajaxurl,
        method: 'POST',
        data: {
          character: character,
          current_health: current_health,
          action: 'update_health',
        },
      });
    });

    $('.willpower').on('click', 'a.fa-stack', function (e) {
      e.preventDefault();
      var $indicator = $(this).children('.indicator').first();
      console.log($indicator);
      if ($indicator.hasClass('fa-slash')) {
        $indicator.removeClass('fa-slash');
      } else {
        $indicator.addClass('fa-slash');
      }

      var total = $(this).parent('.willpower').find('a').length;
      var current = $(this).parent('.willpower').find('a .fa-slash').length;

      $(this).parent('.willpower').find('span').text((total - current)+' willpower');

      var current_willpower = '';
      $(this).parent('.willpower').find('a .indicator').each(function () {
        if ($(this).hasClass('fa-slash')) {
          current_willpower += '1';
        } else {
          current_willpower += '0';
        }
      });
      $(this).parent('.willpower').attr('data-willpower', current_willpower);
      var character = parseInt($(this).parents('li').data('character'));

      $.ajax({
        url: ajaxurl,
        method: 'POST',
        data: {
          character: character,
          current_willpower: current_willpower,
          action: 'update_willpower',
        },
      });
    });

    function pollCharacters() {
      $.ajax({
        url: ajaxurl,
        method: 'POST',
        data: {
          action: 'get_character_data',
        },
        success: function(data) {
          var chars = JSON.parse(data);
          chars.forEach(function() {
            var id = this.id;
            var $current;
            var string;
            var split;
            var num;
            var i;
            if ($('.characters li[data-character="'+id+'"]').length > 0) {
              $current = $('.characters li[data-character="' + id + '"]');
              if ($current.find('.willpower').data('data-willpower') != this.current_willpower) {
                string = this.current_willpower;
                split = string.split("");
                num;
                $current.find('.willpower').html('');
                for (i = 0; i < split.length; i++) {
                  num = parseInt(split[i]);
                  if (num == 0) {
                    $current.find('.willpower').append('<a href="#" class="fa-stack"><i class="far fa-square fa-stack-1x"></i><i class="fas fa-stack-1x indicator"></i></a>');
                  } else if (num == 1) {
                    $current.find('.willpower').append('<a href="#" class="fa-stack"><i class="far fa-square fa-stack-1x"></i><i class="fas fa-slash fa-stack-1x indicator"></i></a>');
                  } else if (num == 2) {
                    $current.find('.willpower').append('<a href="#" class="fa-stack"><i class="far fa-square fa-stack-1x"></i><i class="fas fa-times fa-stack-1x indicator"></i></a>');
                  } else if (num == 3) {
                    $current.find('.willpower').append('<a href="#" class="fa-stack"><i class="far fa-square fa-stack-1x"></i><i class="fas fa-asterisk fa-stack-1x indicator"></i></a>');
                  }
                }
              }
              if ($current.find('.health').data('data-health') != this.current_health) {
                string = this.current_health;
                split = string.split("");
                num;
                $current.find('.health').html('');
                for (i = 0; i < split.length; i++) {
                  num = parseInt(split[i]);
                  if (num == 0) {
                    $current.find('.health').append('<a href="#" class="fa-stack"><i class="far fa-square fa-stack-1x"></i><i class="fas fa-stack-1x indicator"></i></a>');
                  } else if (num == 1) {
                    $current.find('.health').append('<a href="#" class="fa-stack"><i class="far fa-square fa-stack-1x"></i><i class="fas fa-slash fa-stack-1x indicator"></i></a>');
                  } else if (num == 2) {
                    $current.find('.health').append('<a href="#" class="fa-stack"><i class="far fa-square fa-stack-1x"></i><i class="fas fa-times fa-stack-1x indicator"></i></a>');
                  } else if (num == 3) {
                    $current.find('.health').append('<a href="#" class="fa-stack"><i class="far fa-square fa-stack-1x"></i><i class="fas fa-asterisk fa-stack-1x indicator"></i></a>');
                  }
                }
              }
            }
          });
        },
      });
    }

    setInterval(pollCharacters, 5000);
  },
}
