export default {
  init() {
    $("form .dots i.fa-circle").on("click", function () {
      $(this)
        .nextAll("i.fa-circle")
        .removeClass("fas")
        .addClass("far");
      if ($(this).hasClass("far")) {
        $(this)
          .addClass("fas")
          .removeClass("far");
        $(this)
          .prevAll("i.fa-circle")
          .removeClass("far")
          .addClass("fas");
      } else if (
        $(this).hasClass("fas") &&
        $(this).nextAll(".fas").length == 0
      ) {
        $(this)
          .removeClass("fas")
          .addClass("far");
      } else {
        $(this)
          .nextAll(".fas")
          .removeClass("fas")
          .addClass("far");
      }
      var count = $(this)
        .parent(".dots")
        .find(".fas").length;
      $(this)
        .parent(".dots")
        .find("input")
        .val(count);
      $(this)
        .parent(".dots")
        .find("input")
        .change();
    });

    function checkMerits() {
      var meritCount = 0;
      $('[name^="merits_"][name$="_rating"]').each(function() {
        meritCount += parseInt($(this).val());
      });

      $('#merit-count').text((17 - meritCount)+" Remaining");
      $('#merit-count').removeClass('hidden');

      if (meritCount > 17) {
        $('#merit-count').addClass('warn');
      } else {
        $('#merit-count').removeClass('warn');
      }
      // validate merits
      $('ul.merits li').each(function() {
        var prereqs = $(this).data('prereqs');
        var errors = [];
        var $item = $(this);
        if (prereqs != null) {
          prereqs.forEach(function(item) {
            if (item.type === 'Merit') {
              var $merit = $('ul.merits').find('input[type="hidden"][name$="_merit"]'+(item.merit.ID ? '[val="'+item.merit.ID+'"]' : '')).parents('li');
              console.log($merit);
              if ($merit.length > 0) {
                var $rating = $merit.find('input[type="hidden"][name$="_rating"]'+(item.rating ? '[val="'+item.rating+'"]' : ''));
                console.log($rating);
                if (!$rating || $rating.val() < item.rating) {
                  $item.addClass('error');
                  errors.push("Must have the merit "+item.merit.post_title+" rated at least "+item.rating+".");
                }
              }
            } else if (item.type === 'Attribute') {
              if ($('input[name="'+item.attribute+'"]').val() < item.rating) {
                $item.addClass('error');
                errors.push("Must have "+item.attribute.charAt(0).toUpperCase() + item.attribute.slice(1)+" of at least "+item.rating+".");
              }
            } else if (item.type === 'Skill') {
              if ($('input[name="' + item.skill + '"]').val() < item.rating) {
                $item.addClass("error");
                errors.push("Must have " + item.skill.charAt(0).toUpperCase() + item.skill.slice(1).replace("_", " ") + " of at least " + item.rating + ".");
              }
            } else if (item.type === 'Skill Specialty') {
              var $sksp = $('ul.skill-specialties').find('input[type="hidden"][name$="_skill"][val="'+item.skill_specialty+'"]').parents('li');
              if ($sksp.length == 0) {
                $item.addClass('error');
                errors.push("Must have a skill specialty for "+item.skill_specialty+".");
              }
            } else if (item.type === 'Option') {

            }
          });
          if (errors.length == 0) {
            $item.removeClass('error');
          } else {
            $item.find('.error-content').html("<span>"+errors.join("</span><span>")+"</span>");
          }
        }
      });
    }

    $('#attributes-row input[type="hidden"], #skills-row input[type="hidden"]').on('change', function() {
      checkMerits();
    });

    function checkSkillSpecialties() {
      var skillSpCount = $('.skill-specialties li').length;
      $('#skill-specialty-count').text((3 - skillSpCount)+" Remaining");
      if (skillSpCount > 3) {
        $('#skill-specialty-count').addClass('warn');
      } else {
        $('#skill-specialty-count').removeClass('warn');
      }
    }

    function updateWillpower() {
      var amt = 5 + parseInt($('input[name="resolve"]').val());
      var str = "";
      var currentstr = "";
      for (var i = 0; i < amt; i++) {
        str += "<i class='far fa-square'></i>";
        currentstr += "0";
      }
      $("#willpower").html(str);
      $('[name="current_willpower"]').val(currentstr);
    }

    function updateHealth() {
      var amt = parseInt($('input[name="stamina"]').val()) + 5;
      var str = "";
      var currentstr = "";
      for (var i = 0; i < amt; i++) {
        str += "<i class='far fa-square'></i>";
        currentstr += "0";
      }
      $("#health").html(str);
      $('[name="current_health"]').val(currentstr);
    }

    function updateSpeed() {
      var spd =
        parseInt($('input[name="dexterity"]').val()) +
        parseInt($('input[name="strength"]').val()) +
        5;
      $('input[name="speed"]').val(spd);
    }

    function updateInitiative() {
      var ini =
        parseInt($('input[name="dexterity"]').val()) +
        parseInt($('input[name="composure"]').val());
      $('input[name="initiative_mod"]').val(ini);
    }

    function updateDefense() {
      var def =
        Math.min(
          parseInt($('input[name="wits"]').val()),
          parseInt($('input[name="dexterity"]').val())
        ) + parseInt($('input[name="athletics"]').val());
      $('input[name="defense"]').val(def);
    }

    $('input[name="composure"]').on("change", function () {
      updateInitiative();
    });

    $('input[name="resolve"]').on("change", function () {
      updateWillpower();
    });

    $('input[name="stamina"]').on("change", function () {
      updateHealth();
    });

    $('input[name="wits"]').on("change", function () {
      updateDefense();
    });

    $('input[name="dexterity"]').on("change", function () {
      updateDefense();
      updateSpeed();
      updateInitiative();
    });

    $('input[name="strength"]').on("change", function () {
      updateSpeed();
    });

    $('input[name="athletics"]').on("change", function () {
      updateDefense();
    });

    $("#add-merit").on("click", function () {
      var merit = parseInt(
        $("#merits option:selected")
        .first()
        .val()
      );
      $.ajax({
        url: ajaxurl,
        method: "POST",
        data: {
          id: merit,
          action: "get_merit_info",
        },
        success: function (data) {
          var newNum;
          if ($("ul.merits li").length > 0) {
            newNum = $("ul.merits li").length;
          } else {
            newNum = 0;
          }
          var ratingstr = "";
          var specstr = "";
          if (data.ratings.length > 1) {
            ratingstr =
              ' <span class="rating">' +
              data.ratings[0] +
              "</span>";
          }
          if (data.has_specification) {
            specstr = ' <span class="specification">()</span>';
          }
          var newItem =
            "<li data-prereqs='" +
            JSON.stringify(data.prerequisites_list) +
            "'><span class='label'><span class='meritname'>" +
            data.name +
            "</span>" +
            specstr +
            ratingstr +
            ' <span class="alert"><i class="fas fa-exclamation-triangle"></i><span class="sr-only">Alert</span><span class="error-content"></span></span>' +
            " <button class='js-modal edit' data-modal-content-id='merits-modal'><i class='fas fa-pencil-alt'></i></button> <button class='delete'><i class='fas fa-trash'></i></button><div class='description'></div><input type='hidden' name='merits_" +
            newNum +
            "_merit' value='" +
            data.id +
            "' class='merit-id' /><input type='hidden' name='merits_" +
            newNum +
            "_rating' value='" +
            data.ratings[0] +
            "' /><input type='hidden' name='merits_" +
            newNum +
            "_specification' value='' /><input type='hidden' name='merits_" +
            newNum +
            "_description' value='' /></li>";
          $("ul.merits").append(newItem);
          $('[name="merits"]').val($("ul.merits li").length);
          checkMerits();
        },
      });
    });

    $(".merits").on("click", ".edit", function () {
      var merit = $(this)
        .parents("li")
        .find(".merit-id")
        .val();
      var currentVal = $(this)
        .parents("li")
        .find(".merit-rating")
        .val();
      var currentSpec = $(this)
        .parents("li")
        .find(".merit-spec")
        .val();
      var currentDesc = $(this)
        .parents("li")
        .find(".merit-desc")
        .val();
      var idx = $(this)
        .parents("li")
        .index();
      $.ajax({
        url: ajaxurl,
        method: "POST",
        data: {
          id: merit,
          action: "get_merit_info",
        },
        success: function (data) {
          $("#modal-content").attr("data-index", idx);
          $(
            "#modal-content input, #modal-content textarea"
          ).val("");
          $("#modal-content select").empty();
          $("#modal-content h4").text(data.name);
          $("#modal-content .description").html(
            data.description
          );
          $("#modal-content .prerequisites").html(
            "<strong>Prerequsites:</strong> " +
            data.prerequisites
          );
          if (data.has_specification) {
            $("#modal-content #specification-row").show();
            $("#modal-content #specification").val(currentSpec);
          } else {
            $("#modal-content #specification-row").hide();
          }
          if (data.has_description) {
            $("#modal-content #description-row").show();
            $("#modal-content #description").val(currentDesc);
          } else {
            $("#modal-content #description-row").hide();
          }
          $("#modal-content a")
            .attr("rel", "external")
            .attr("target", "_blank");
          var option;
          for (var i = 0; i < data.ratings.length; i++) {
            option =
              '<option value="' +
              data.ratings[i] +
              '"' +
              (currentVal === data.ratings[i] ?
                ' selected="selected"' :
                "") +
              ">" +
              data.ratings[i] +
              "</option>";
            $("#modal-content select").append(option);
          }
          if (data.ratings.length === 1) {
            $("#modal-content select").prop(
              "disabled",
              "disabled"
            );
          } else {
            $("#modal-content select").removeProp("disabled");
          }
        },
      });
    });

    $("body").on("click", "#save-merit", function () {
      var rating = $(".modal #ratings option:selected").val();
      var specification = $(".modal #specification").val();
      var description = $(".modal #description").val();
      var idx = $(".modal #modal-content").data("index") + 1;
      $('[name="merits_' + (idx - 1) + "_rating").val(rating);
      $('[name="merits_' + (idx - 1) + "_specification").val(
        specification
      );
      $('[name="merits_' + (idx - 1) + "_description").val(
        description
      );
      $(".merits li:nth-child(" + idx + ") .description").html(
        description
      );
      $(".merits li:nth-child(" + idx + ") .rating").text(
        rating
      );
      $(
        ".merits li:nth-child(" + idx + ") .specification"
      ).text("(" + specification + ")");
      $(".modal #js-modal-close").click();
    });

    $(".merits").on("click", ".delete", function () {
      var yn = confirm(
        "Are you sure you want to delete this merit?"
      );
      if (yn) {
        $(this)
          .parents("li")
          .detach();
        $('[name="merits"]').val($("ul.merits li").length);
      }
    });

    $("#add-specialty").on("click", function () {
      var skill = $("#skills_list option:selected").val();
      var specialty = $("#specialty_name").val();
      var num = $(".skill-specialties li").length;
      var item =
        '<li><strong class="skill">' +
        skill +
        ':</strong> <span class="specialty">' +
        specialty +
        '</span> <button type="button" class="delete"><i class="fas fa-trash"></i><span class="sr-only">Delete</span></button><input type="hidden" name="skill_specialties_' +
        num +
        '_skill" value="' +
        skill +
        '" /><input type="hidden" name="skill_specialties_' +
        num +
        '_specialty" value="' +
        specialty +
        '" /></li>';
      $(".skill-specialties").append(item);
      $('[name="skill_specialties"]').val(
        $("ul.skill-specialties li").length
      );
      checkSkillSpecialties();
    });

    $(".skill-specialties").on("click", ".delete", function () {
      var yn = confirm(
        "Are you sure you want to delete this skill specialty?"
      );
      if (yn) {
        $(this)
          .parents("li")
          .detach();
        $('[name="skill_specialties"]').val(
          $("ul.skill-specialties li").length
        );
      }
      checkSkillSpecialties();
    });

    $("#character-sheet #add-condition").on("click", function () {
      var condition = $(
        "#conditions_list option:selected"
      ).val();
      var conditionName = $(
        "#conditions_list option:selected"
      ).text();
      var num = $(".conditions li").length;
      var note = $("#condition_note").val();
      var item =
        "<li><strong>" +
        conditionName +
        '</strong> <button class="delete" type="button"><i class="fas fa-trash"></i><span class="sr-only">Delete</span></button><br />' +
        note +
        '<input type="hidden" name="conditions_' +
        num +
        '_condition" value="' +
        condition +
        '" /><input type="hidden" name="conditions_' +
        num +
        '_note" value="' +
        note +
        '" /></li>';
      $(".conditions").append(item);
      $('[name="conditions"]').val(
        $("ul.conditions li").length
      );
    });

    $("#character-sheet .conditions").on("click", ".delete", function () {
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

    function checkVirtue()
    {
      if ($('[name="virtue"] option:selected').length > 0) {
        return true;
      }
      return false;
    }

    function checkVice() {
      if ($('[name="vice"] option:selected').length > 0) {
        return true;
      }
      return false;
    }

    function checkAttributes() {
      var mentals = parseInt($('[name="intelligence"]').val()) + parseInt($('[name="wits"]').val()) + parseInt($('[name="resolve"]').val()) - 3;
      var physicals = parseInt($('[name="strength"]').val()) + parseInt($('[name="dexterity"]').val()) + parseInt($('[name="stamina"]').val()) - 3;
      var socials = parseInt($('[name="presence"]').val()) + parseInt($('[name="manipulation"]').val()) + parseInt($('[name="composure"]').val()) - 3;

      // general error validation
      if (mentals > 6) {
        $('#mental-count').text((6 - mentals) + " Remaining").addClass('warn').removeClass('hidden');
      } else {
        $('#mental-count').addClass('hidden');
      }
      if (physicals > 6) {
        $('#physical-count').text((6 - physicals) + " Remaining").addClass('warn').removeClass('hidden');
      } else {
        $('#physical-count').addClass('hidden');
      }
      if (socials > 6) {
        $('#social-count').text((6 - socials) + " Remaining").addClass('warn').removeClass('hidden');
      } else {
        $('#social-count').addClass('hidden');
      }

      var primary_name = "";
      var secondary_name = "";
      var tertiary_name = "";
      var primary_val = 0;
      var secondary_val = 0;
      var tertiary_val = 0;

      // if user has allocated all dots (or has too many)
      if (mentals + physicals + socials >= 13) {
        if (mentals >= physicals && mentals >= socials) {
          primary_name = "mental";
          primary_val = mentals;
          // mental is primary category
          if (physicals >= socials) {
            // physical is secondary
            secondary_name = "physical";
            secondary_val = physicals;
            tertiary_name = "social";
            tertiary_val = socials;
          } else {
            // social is secondary
            secondary_name = "social";
            secondary_val = socials;
            tertiary_name = "physical";
            tertiary_val = physicals;
          }
        } else if (physicals >= mentals && physicals >= socials) {
          // physical is primary
          primary_name = "physical";
          primary_val = physicals;
          if (mentals >= socials) {
            // mental is secondary
            secondary_name = "mental";
            secondary_val = mentals;
            tertiary_name = "social";
            tertiary_val = socials;
          } else {
            // social is secondary
            secondary_name = "social";
            secondary_val = socials;
            tertiary_name = "mental";
            tertiary_val = mentals;
          }
        } else {
          // social is primary
          primary_name = "social";
          primary_val = socials;
          if (mentals >= physicals) {
            // mental is secondary
            secondary_name = "mental";
            secondary_val = mentals;
            tertiary_name = "physical";
            tertiary_val = physicals;
          } else {
            // physical is secondary
            secondary_name = "physical";
            secondary_val = physicals;
            tertiary_name = "mental";
            tertiary_val = mentals;
          }
        }
        if (primary_val >= 6) {
          // configuration should be 6/4/3
          if (primary_val > 6) {
            $('#' + primary_name + "-count").removeClass('hidden').addClass('warn').text((6 - primary_val) + " Remaining");
          } else {
            $('#' + primary_name + "-count").addClass('hidden');
          }
          if (secondary_val > 4) {
            $('#' + secondary_name + "-count").removeClass('hidden').addClass('warn').text((4 - secondary_val) + " Remaining");
          } else if (secondary_val < 4) {
            $('#' + secondary_name + "-count").removeClass('hidden').removeClass('warn').text((4 - secondary_val) + "Remaining");
          } else {
            $('#' + secondary_name).addClass('hidden');
          }
          if (tertiary_val > 3) {
            $('#' + tertiary_name + "-count").removeClass('hidden').addClass('warn').text((3 - tertiary_val) + " Remaining");
          } else if (tertiary_val < 3) {
            $('#' + tertiary_name + "-count").removeClass('hidden').removeClass('warn').text((3 - tertiary_val) + " Remaining");
          } else {
            $('#' + tertiary_name + "-count").addClass('hidden');
          }
        } else {
          if (secondary_val === 5) {
            // configuration should be 5/5/3
            if (secondary_val > 5) {
              $('#' + secondary_name + "-count").removeClass('hidden').addClass('warn').text((5 - secondary_val) + " Remaining");
            } else if (secondary_val < 5) {
              $('#' + secondary_name + "-count").removeClass('hidden').removeClass('warn').text((5 - secondary_val) + " Remaining");
            } else {
              $('#' + secondary_name + "-count").addClass('hidden');
            }
            if (tertiary_val > 3) {
              $('#' + tertiary_name + "-count").removeClass('hidden').addClass('warn').text((3 - tertiary_val) + " Remaining");
            } else if (tertiary_val < 3) {
              $('#' + tertiary_name + "-count").removeClass('hidden').removeClass('warn').text((3 - tertiary_val) + " Remaining");
            } else {
              $('#' + tertiary_name + "-count").addClass('hidden');
            }
          } else {
            // configuration should be 5/4/4
            if (secondary_val > 4) {
              $('#' + secondary_name + "-count").removeClass('hidden').addClass('warn').text((4 - secondary_val) + " Remaining");
            } else if (secondary_val < 4) {
              $('#' + secondary_name + "-count").removeClass('hidden').removeClass('warn').text((4 - secondary_val) + " Remaining");
            }
            if (tertiary_val > 4) {
              $('#' + tertiary_name + "-count").removeClass('hidden').addClass('warn').text((4 - tertiary_val) + " Remaining");
            } else if (tertiary_val < 4) {
              $('#' + tertiary_name + "-count").removeClass('hidden').removeClass('warn').text((4 - tertiary_val) + " Remaining");
            } else {
              $('#' + tertiary_name + "-count").addClass('hidden');
            }
          }
        }
      }
    }

    function checkSkills() {
      var mentals = 0;
      var socials = 0;
      var physicals = 0;

      mentals = $('#mental-skills input').map(function() {
        return parseInt($(this).val());
      }).get().reduce((a, b) => a + b);

      socials = $('#social-skills input').map(function () {
        return parseInt($(this).val());
      }).get().reduce((a, b) => a + b);

      physicals = $('#physical-skills input').map(function () {
        return parseInt($(this).val());
      }).get().reduce((a, b) => a + b);

      // general error validation
      if (mentals > 11) {
        $('#mental-skills-count').text((11 - mentals) + " Remaining").addClass('warn').removeClass('hidden');
      } else {
        $('#mental-skills-count').addClass('hidden');
      }
      if (physicals > 11) {
        $('#physical-skills-count').text((11 - physicals) + " Remaining").addClass('warn').removeClass('hidden');
      } else {
        $('#physical-skills-count').addClass('hidden');
      }
      if (socials > 11) {
        $('#social-skills-count').text((11 - socials) + " Remaining").addClass('warn').removeClass('hidden');
      } else {
        $('#social-skills-count').addClass('hidden');
      }

      var primary_name = "";
      var secondary_name = "";
      var tertiary_name = "";
      var primary_val = 0;
      var secondary_val = 0;
      var tertiary_val = 0;

      // if user has allocated all dots (or has too many)
      if (mentals + physicals + socials >= 22) {
        if (mentals >= physicals && mentals >= socials) {
          primary_name = "mental";
          primary_val = mentals;
          // mental is primary category
          if (physicals >= socials) {
            // physical is secondary
            secondary_name = "physical";
            secondary_val = physicals;
            tertiary_name = "social";
            tertiary_val = socials;
          } else {
            // social is secondary
            secondary_name = "social";
            secondary_val = socials;
            tertiary_name = "physical";
            tertiary_val = physicals;
          }
        } else if (physicals >= mentals && physicals >= socials) {
          // physical is primary
          primary_name = "physical";
          primary_val = physicals;
          if (mentals >= socials) {
            // mental is secondary
            secondary_name = "mental";
            secondary_val = mentals;
            tertiary_name = "social";
            tertiary_val = socials;
          } else {
            // social is secondary
            secondary_name = "social";
            secondary_val = socials;
            tertiary_name = "mental";
            tertiary_val = mentals;
          }
        } else {
          // social is primary
          primary_name = "social";
          primary_val = socials;
          if (mentals >= physicals) {
            // mental is secondary
            secondary_name = "mental";
            secondary_val = mentals;
            tertiary_name = "physical";
            tertiary_val = physicals;
          } else {
            // physical is secondary
            secondary_name = "physical";
            secondary_val = physicals;
            tertiary_name = "mental";
            tertiary_val = mentals;
          }
        }

        if (primary_val > 11) {
          $('#' + primary_name + "-skills-count").removeClass('hidden').addClass('warn').text((11 - primary_val) + " Remaining");
        } else {
          $('#' + primary_name + "-skills-count").addClass('hidden');
        }
        if (secondary_val > 7) {
          $('#' + secondary_name + "-skills-count").removeClass('hidden').addClass('warn').text((7 - secondary_val) + " Remaining");
        } else if (secondary_val < 7) {
          $('#' + secondary_name + "-skills-count").removeClass('hidden').removeClass('warn').text((7 - secondary_val) + "Remaining");
        } else {
          $('#' + secondary_name).addClass('hidden');
        }
        if (tertiary_val > 4) {
          $('#' + tertiary_name + "-skills-count").removeClass('hidden').addClass('warn').text((4 - tertiary_val) + " Remaining");
        } else if (tertiary_val < 4) {
          $('#' + tertiary_name + "-skills-count").removeClass('hidden').removeClass('warn').text((4 - tertiary_val) + " Remaining");
        } else {
          $('#' + tertiary_name + "-skills-count").addClass('hidden');
        }
      }
    }

    $('#attributes-row input').on('change', function() {
      checkAttributes();
    });

    $('#skills-row input').on('change', function() {
      checkSkills();
    });

    $(window).on('load', function() {
      checkAttributes();
      checkSkills();
      checkMerits();
      checkSkillSpecialties();
    });

    function validateSubmission()
    {
      // check virtue
      checkVirtue();
      // check vice
      checkVice();
      // check attributes
      // check skills
      // check merits
      // check integrity
      // check skill specialties
      // check questionnaire
    }

    $('#save-submit').on('click', function(e) {
      e.preventDefault();
      // validate first
      $('input[name="status"]').val("Submitted");
      $(this).parents('form').submit();
    });
  },
}
