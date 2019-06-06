export default {
  init() {
    $('#wpadminbar').hide();

    $(window).on('load', function() {
      jQuery('html').attr("style", "margin-top: 0px !important");
      var charcookie = 'openCharacters' + "=";
      var tabcookie = 'openTab' + "=";
      var decodedCookie = decodeURIComponent(document.cookie);
      var ca = decodedCookie.split(";");
      for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == " ") {
          c = c.substring(1);
        }
        if (c.indexOf(charcookie) == 0) {
          var charstring = c.substring(charcookie.length, c.length);
          var characters = JSON.parse(charstring);
          characters.forEach(function(elt) {
            $('ol li[data-character="' + elt + '"]').addClass("open");
            $('ol li[data-character="' + elt + '"]').find('.character-content').slideDown();
          });
        } else if (c.indexOf(tabcookie) == 0) {
          var tab = c.substring(tabcookie.length, c.length);
          $('.dashboard-tabs #'+tab+'-tab').trigger('click');
        }
      }
    });

    $('.tab a, .tab-link').on('click', function(e) {
      e.preventDefault();
      var tabid = $(this).attr('data-id').replace('-tab', '');
      $('#'+tabid).show().siblings('.tab-content').hide();
      if ($(this).attr("href").replace("#", "") !== "") {
        $(window).scrollTop($($(this).attr('href')).offset().top);
      }
      var d = new Date();
      d.setTime(d.getTime() + 30 * 24 * 60 * 60 * 1000);
      var expires = "expires=" + d.toUTCString();
      document.cookie = 'openTab=' + tabid + ';' + expires + ';path=/';
    });

    $(".merit-link").on("click", function() {
      var merit = parseInt($(this).data('id'));
      $.ajax({
        url: ajaxurl,
        method: "POST",
        data: {
          id: merit,
          action: "get_merit_info",
        },
        success: function(data) {
          $("#modal-content h4").text(data.name);
          $("#modal-content .description").html(data.description);
          if (data.prerequisites) {
            $("#modal-content .prerequisites").html(
              "<strong>Prerequisites:</strong> " + data.prerequisites
            );
          } else {
            $('#modal-content .prerequisites').html("");
          }
        },
      });
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
      var openItems = JSON.stringify($(this).parents('li.open').map(function() {
        return $(this).data('character');
      }).get());
      var d = new Date();
      d.setTime(d.getTime() + 30 * 24 * 60 * 60 * 1000);
      var expires = "expires=" + d.toUTCString();
      document.cookie = 'openCharacters='+openItems+';'+expires+';path=/';
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

      var character = parseInt($(this).parents('.character').data('character'));

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
      var character = parseInt($(this).parents('.character').data('character'));

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
      var character = parseInt($(this).parents('.character').data('character'));
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

    $('textarea[name="st_notes"]').on('change', function() {
      var character = parseInt($(this).parents('.character').data('character'));
      var content = $(this).val();
      $.ajax({
        url: ajaxurl,
        method: 'POST',
        data: {
          action: 'update_notes',
          character: character,
          notes: content
        }
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

    $('.xp-form').on('submit', function(e) {
      e.preventDefault();
      console.log('form submitted');
      var char = $(this).find('input[name="character"]');
      var amt = parseInt($(this).find('input[name="amount"]'));
      var reason = $(this).find('input[name="reason"]');
      var data = {
        action: char == "all" ? "mass_add_experience" : "add_experience",
        amount: amt,
        reason: reason
      };
      if (char != 'all') {
        data.character = parseInt(char);
      }
      console.log(data);
    });

    $('.conditions h4').on('click', function() {
      var char = $(this).parents('li').data('character');
      setTimeout(function() {
        $('dialog.modal .condition-form').attr('data-character', char);
      }, 50);
    });

    $('body').on("click", ".add-condition", function () {
      var $conditions = $(this).parents('form');
      var condition = $conditions.find(".conditions_list option:selected").val();
      var note = $conditions.find(".condition_note").val();
      var character = parseInt($conditions.attr('data-character'));
      $('dialog.modal #js-modal-close').trigger('click');
      $.ajax({
        url: ajaxurl,
        method: 'POST',
        dataType: 'json',
        data: {
          action: 'add_condition',
          condition: condition,
          note: note,
          character: character,
        },
        success: function(data) {
          var $c = $('.characters li[data-character="'+character+'"]');
          $c.find('.char-conditions').empty();
          for (var i = 0; i < data.length; i++) {
            var item =
              "<li>" +
              data[i].condition + (data[i].note ? ' (' + data[i].note + ')' : '') + ' <button class="resolve-button" type="button">Resolve</button> <button class="delete-button" type="button"><i class="fas fa-trash"></i><span class="sr-only">Delete</span></button>' +
              '</li>';
            $c.find('.char-conditions').append(item);
          }
        },
      });
    });

    $('body').on('click', '.equipment-list a', function (e) {
      e.preventDefault();
      $(this).next('dl').slideToggle();
    });

    $(".char-conditions").on("click", ".resolve-button", function () {
      var $conditions = $(this).parents('.conditions');
      var condition = $(this).parents('li').index();
      var character = $conditions.parents('li').data('character');
      var yn = confirm(
        "Resolve this condition?"
      );
      if (yn) {
        $.ajax({
          url: ajaxurl,
          method: 'POST',
          dataType: 'json',
          data: {
            action: 'resolve_condition',
            condition: condition,
            character: character,
          },
          success: function (data) {
            $conditions.find('.char-conditions').empty();
            for (var i = 0; i < data.length; i++) {
              var item =
                "<li>" +
                data[i].condition + (data[i].note ? ' (' + data[i].note + ')' : '') + ' <button class="resolve-button" type="button">Resolve</button> <button class="delete-button" type="button"><i class="fas fa-trash"></i><span class="sr-only">Delete</span></button>' +
                '</li>';
              $conditions.find('.char-conditions').append(item);
            }
          },
        });
      }
    });

    $(".char-conditions").on("click", ".delete-button", function () {
      var $conditions = $(this).parents('.conditions');
      var condition = $(this).parents('li').index();
      var character = $conditions.parents('li').data('character');
      var yn = confirm(
        "Delete this condition?"
      );
      if (yn) {
        $.ajax({
          url: ajaxurl,
          method: 'POST',
          dataType: 'json',
          data: {
            action: 'resolve_condition',
            condition: condition,
            character: character,
            delete: true,
          },
          success: function (data) {
            $conditions.find('.char-conditions').empty();
            for (var i = 0; i < data.length; i++) {
              var item =
                "<li>" +
                data[i].condition + (data[i].note ? ' (' + data[i].note + ')' : '') + ' <button class="resolve-button" type="button">Resolve</button> <button class="delete-button" type="button"><i class="fas fa-trash"></i><span class="sr-only">Delete</span></button>' +
                '</li>';
              $conditions.find('.char-conditions').append(item);
            }
          },
        });
      }
    });

    $('.char-equipment h4').on('click', function () {
      var char = $(this).parents('li').data('character');
      setTimeout(function () {
        $('dialog.modal .equipment-form').attr('data-character', char);
      }, 50);
    });

    $('body').on("click", ".add-equipment", function () {
      var $equipment = $(this).parents('form');
      var equipment = $equipment.find(".equipment_list option:selected").val();
      var note = $equipment.find(".equipment_note").val();
      var character = parseInt($equipment.attr('data-character'));
      var uses = $equipment.find(".equipment-uses").val();
      $('dialog.modal #js-modal-close').trigger('click');
      $.ajax({
        url: ajaxurl,
        method: 'POST',
        dataType: 'json',
        data: {
          action: 'add_equipment',
          item: equipment,
          note: note,
          uses: uses,
          character: character,
        },
        success: function (data) {
          var $c = $('.characters li[data-character="' + character + '"]');
          $c.find('.equipment-list').empty();
          data.forEach(function(i) {
            var e =
              "<li>" +
              "<a href='#'><strong>" + i.item + "</strong></a>" +
              "<dl>" +
              "<dt>Type</dt>"+
              "<dd>" + i.type.charAt(0).toUpperCase() + i.type.slice(1); + "</dd>" +
              (i.durability ? "<dt>Durability</dt><dd>"+i.durability+"</dd>" : '') +
              (i.damage ? "<dt>Damage</dt><dd>" + i.damage + "</dd>" : '') +
              (i.initiative_modifier ? "<dt>Initiative Modifier</dt><dd>" + i.initative_modifier + "</dd>" : '') +
              (i.required_strength ? "<dt>Required Strength</dt><dd>" + i.required_strength + "</dd>" : '') +
              (i.clip_size ? "<dt>Clip Size</dt><dd>" + i.clip_size + "</dd>" : '') +
              (i.general_armor ? "<dt>General Armor</dt><dd>" + i.general_armor + "</dd>" : '') +
              (i.ballistic_armor ? "<dt>Ballistic Armor</dt><dd>" + i.ballistic_armor + "</dd>" : '') +
              (i.defense ? "<dt>Defense</dt><dd>" + i.defense + "</dd>" : '') +
              (i.speed ? "<dt>Speed</dt><dd>" + i.speed + "</dd>" : '') +
              (i.cost ? "<dt>Damage</dt><dd>" + i.cost + "</dd>" : '') +
              (i.qualities ? "<dt>Damage</dt><dd>" + i.qualities.join(", ") + "</dd>" : '') +
              (i.note ? "<dt>Notes</dt><dd>" + i.note + "</dd>" : '') +
              "</dl></li>";
            $c.find('.equipment-list').append(e);
          });
        },
      });
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

    $('#init-mod-wrapper').on('click', function() {
      var roll = Math.floor(Math.random() * 10) + 1;
      var mod = parseInt($('#initiative-mod').text());
      $('.initiative-roll').text(roll+mod);
    });

    $('.roll-row').on('click', function () {
      var roll = Math.floor(Math.random() * 10) + 1;
      $('.whatever-roll').text(roll);
    });

    $('.heal-button').on('click', function(e) {
      e.preventDefault();
      var yn = confirm('Are you sure you want to heal all active characters?');
      if (yn) {
        $.ajax({
          url: ajaxurl,
          method: 'POST',
          data: {
            weeks: parseInt($('.weeks-field').val()),
            action: 'do_healing'
          }
        });
      }
      return false;
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
              if (parseInt($current.find('.current-integrity').text()) != item.integrity) {
                $current.find('.current-integrity').text(item.integrity);
              }
              if ($current.find('textarea[name="st_notes"]').val() !== item.st_notes) {
                $current.find('textarea[name="st_notes"]').val(item.st_notes);
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
