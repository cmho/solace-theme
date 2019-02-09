export default {
  init() {
    $('#wpadminbar').hide();

    $(window).on('load', function() {
      jQuery('html').attr("style", "margin-top: 0px !important");
    });

    $('#login').on('submit', function(e) {
      e.preventDefault();
      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
          action: 'ajaxlogin',
          username: $('#login #username').val(),
          password: $('#login #password').val(),
          security: $('#login #security').val(),
        },
        success: function(data) {
          console.log(data);
          $('body').fadeOut();
          $('body').load('/dashboard/');
          if (!data.loggedin) {
            $('body').find('.status').addClass('error').text('There was an error logging you in; please try again.');
          }
          $('body').fadeIn();
        },
      })
    });

    $('ol li h3 a').on('click', function(e) {
      e.preventDefault();
      $(this).parents('li').toggleClass('open');
      $(this).parents('li').find('.character-content').slideToggle();
    });

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

    $('.breaking-point').on('click', function() {
      var character = parseInt($(this).parents('li').data('character'));
      var $num = $(this).siblings('span').first();
      $.ajax({
        url: ajaxurl,
        method: 'POST',
        data: {
          action: 'breaking_point',
          character: character,
        },
        success: function(data) {
          $num.text(data);
        },
      });
    });

    $('#beat-button').on('click', function() {
      $.ajax({
        url: ajaxurl,
        method: 'POST',
        data: {
          action: 'add_beat',
        },
        success: function(data) {
          $('.beat-count').text(data);
        },
      });
      var ding = document.getElementById('ding');
      ding.play();
    });

    $(".add-condition").on("click", function () {
      var condition = $(
        "#conditions_list option:selected"
      ).val();
      var conditionName = $(
        "#conditions_list option:selected"
      ).text();
      var num = $(this).parents('.conditions').find(".char-conditions li").length;
      var note = $("#condition_note").val();
      var item =
        "<li>" +
        conditionName +(note ? ' ('+note+')' : '')+' <button class="delete" type="button"><i class="fas fa-trash"></i><span class="sr-only">Resolve</span></button>' +
        '<input type="hidden" name="conditions_' +
        num +
        '_condition" value="' +
        condition +
        '" /><input type="hidden" name="conditions_' +
        num +
        '_note" value="' +
        note +
        '" /></li>';
      $(this).parents('.conditions').find(".char-conditions").append(item);
      $('[name="char-conditions"]').val(
        $(this).parents('.conditions').find("ul.char-conditions li").length
      );
    });

    $(".conditions").on("click", ".delete", function () {
      var yn = confirm(
        "Are you sure you want to delete this condition?"
      );
      if (yn) {
        $(this)
          .parents("li")
          .detach();
        $('[name="conditions"]').val(
          $("ul.conditions li").length
        );
      }
    });

    $('#character-search').on('submit', function(e) {
      e.preventDefault();
      var search = $(this).find('[name="search"]').val().toLowerCase();
      if (search == "") {
        $('ol.characters li').show();
      } else {
        $('ol.characters li h3 a').each(function() {
          var txt = $(this).text().toLowerCase();
          console.log(txt);
          if (txt.search(search) != -1) {
            $(this).parents('li').show();
          } else {
            $(this).parents('li').hide();
          }
        })
      }
    });

    function pollBeats() {
      $.ajax({
        url: ajaxurl,
        method: 'POST',
        data: {
          action: 'get_beats',
        },
        success: function(data) {
          var newBeats = parseInt(data);
          var oldBeats = parseInt($('.beat-count').text());
          if (newBeats != oldBeats) {
            var ding = document.getElementById('ding');
            ding.play();
            $('.beat-count').text(newBeats);
          }
        },
      });
    }

    function pollCharacters() {
      $.ajax({
        url: ajaxurl,
        method: 'POST',
        data: {
          action: 'get_character_data',
        },
        success: function(data) {
          var chars = JSON.parse(data);
          chars.forEach(function(item) {
            var id = item.id;
            var $current;
            var string;
            var split;
            var num;
            var i;
            if ($('.characters li[data-character="'+id+'"]').length > 0) {
              $current = $('.characters li[data-character="' + id + '"]');
              if ($current.find('.willpower').data('data-willpower') != item.current_willpower) {
                string = item.current_willpower;
                split = string.split("");
                num;
                $current.find('.willpower').html('<h4>Willpower</h4>');
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
              if ($current.find('.health').data('data-health') != item.current_health) {
                string = item.current_health;
                split = string.split("");
                num;
                $current.find('.health').html('<h4>Health</h4>');
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
    setInterval(pollBeats, 5000);
  },
  finalize() {
  },
}
