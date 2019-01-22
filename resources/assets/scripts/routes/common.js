export default {
  init() {
    // JavaScript to be fired on all pages
    $('form .dots i.fa-circle').on('click', function () {
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
            newNum = $('ul.merits li').length;
          } else {
            newNum = 0;
          }
          var ratingstr = "";
          var specstr = "";
          if (data.ratings.length > 1) {
            ratingstr = ' <span class="rating">'+data.ratings[0]+'</span>';
          }
          if (data.has_specification) {
            specstr = ' <span class="specification">()</span>';
          }
          var newItem = "<li><span class='label'><span class='meritname'>" + data.name + "</span>"+specstr+ratingstr+" <button class='js-modal edit' data-modal-content-id='merits-modal'><i class='fas fa-pencil-alt'></i></button> <button class='delete'><i class='fas fa-trash'></i></button><div class='description'></div><input type='hidden' name='merits_" + newNum + "_merit' value='" + data.id + "' class='merit-id' /><input type='hidden' name='merits_" + newNum + "_rating' value='" + data.ratings[0] + "' /><input type='hidden' name='merits_" + newNum + "_specification' value='' /><input type='hidden' name='merits_" + newNum + "_description' value='' /></li>";
          $('ul.merits').append(newItem);
          $('[name="merits"]').val($('ul.merits li').length);
        },
      })
    });

    $('.merits').on('click', '.edit', function () {
      var merit = $(this).parents('li').find('.merit-id').val();
      var currentVal = $(this).parents('li').find('.merit-rating').val();
      var currentSpec = $(this).parents('li').find('.merit-spec').val();
      var currentDesc = $(this).parents('li').find('.merit-desc').val();
      var idx = $(this).parents('li').index();
      $.ajax({
        url: ajaxurl,
        method: 'POST',
        data: {
          id: merit,
          action: 'get_merit_info',
        },
        success: function(data) {
          $('#modal-content').attr('data-index', idx);
          $('#modal-content input, #modal-content textarea').val("");
          $('#modal-content select').empty();
          $('#modal-content h4').text(data.name);
          $('#modal-content .description').html(data.description);
          $('#modal-content .prerequisites').html('<strong>Prerequsites:</strong> '+data.prerequisites);
          if (data.has_specification) {
            $('#modal-content #specification-row').show();
            $('#modal-content #specification').val(currentSpec);
          } else {
            $('#modal-content #specification-row').hide();
          }
          if (data.has_description) {
            $('#modal-content #description-row').show();
            $('#modal-content #description').val(currentDesc)
          } else {
            $('#modal-content #description-row').hide();
          }
          var option;
          for (var i = 0; i < data.ratings.length; i++) {
            option = '<option value="'+data.ratings[i]+'"'+((currentVal === data.ratings[i]) ? ' selected="selected"' : '')+'>'+data.ratings[i]+'</option>';
            $('#modal-content select').append(option);
          }
          if (data.ratings.length === 1) {
            $('#modal-content select').prop("disabled", "disabled");
          } else {
            $('#modal-content select').removeProp("disabled");
          }
        },
      });
    });

    $('body').on('click', '#save-merit', function() {
      var rating = $('.modal #ratings option:selected').val();
      var specification = $('.modal #specification').val();
      var description = $('.modal #description').val();
      var idx = $('.modal #modal-content').data('index')+1;
      $('[name="merits_'+(idx-1)+'_rating').val(rating);
      $('[name="merits_' +(idx-1)+ "_specification").val(specification);
      $('[name="merits_' +(idx-1)+ "_description").val(description);
      $(".merits li:nth-child("+idx+") .description").html(description);
      $('.merits li:nth-child('+idx+') .rating').text(rating);
      $('.merits li:nth-child('+idx+') .specification').text("("+specification+")");
      $('.modal #js-modal-close').click();
    });

    $('.merits').on('click', '.delete', function () {
      var yn = confirm('Are you sure you want to delete this merit?');
      if (yn) {
        $(this).parents('li').detach();
        $('[name="merits"]').val($('ul.merits li').length);
      }
    });

    $('#add-specialty').on('click', function() {
      var skill = $('#skills_list option:selected').val();
      var specialty = $('#specialty_name').val();
      var num = $('.skill-specialties li').length;
      var item = '<li><strong class="skill">'+skill+':</strong> <span class="specialty">'+specialty+'</span> <button type="button" class="delete"><i class="fas fa-trash"></i></button><input type="hidden" name="skill_specialties_'+num+'_skill" value="'+skill+'" /><input type="hidden" name="skill_specialties_'+num+'_specialty" value="'+specialty+'" /></li>';
      $('.skill-specialties').append(item);
      $('[name="skill_specialties"]').val($('ul.skill-specialties li').length);
    });

    $(".skill-specialties").on("click", ".delete", function() {
      var yn = confirm("Are you sure you want to delete this skill specialty?");
      if (yn) {
        $(this)
          .parents("li")
          .detach();
        $('[name="skill_specialties"]').val($("ul.skill-specialties li").length);
      }
    });

    $('#add-condition').on('click', function() {
      var condition = $('#conditions_list option:selected').val();
      var conditionName = $('#conditions_list option:selected').text();
      var num = $('.conditions li').length;
      var note = $('#condition_note').val();
      var item = '<li><strong>'+conditionName+'</strong><br />'+conditionNote+'<input type="hidden" name="conditions_'+num+'_condition" val="'+condition+'" /><input type="hidden" name="conditions_'+num+'_note" val="'+note+'" /></li>';
      $('.conditions').append(item);
      $('[name="conditions"]').val($('ul.conditions li').length);
    });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
