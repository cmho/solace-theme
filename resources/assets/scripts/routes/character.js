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
      $('ul.merits > li').each(function() {
        var prereqs = $(this).data('prereqs');
        var errors = [];
        var $item = $(this);
        if (prereqs != null && prereqs != false) {
          prereqs.forEach(function(item) {
            if (item.type === 'Merit') {
              var $merit = $('ul.merits').find('input[type="hidden"][name$="_merit"]'+(item.merit.ID ? '[val="'+item.merit.ID+'"]' : '')).parents('li');
              if ($merit.length > 0) {
                var $rating = $merit.find('input[type="hidden"][name$="_rating"]'+(item.rating ? '[val="'+item.rating+'"]' : ''));
                if (!$rating || $rating.val() < item.rating) {
                  $item.addClass('error');
                  errors.push("Must have the merit "+item.merit.post_title+" rated at least "+item.rating+".");
                }
              } else {
                $item.addClass("error");
                errors.push("Must have the merit "+item.merit.post_title+" rated at least "+item.rating+".");
              }
            } else if (item.type === 'Attribute') {
              if ($('input[name="'+item.attribute+'"]').val() < item.rating) {
                $item.addClass('error');
                errors.push("Must have "+item.attribute.charAt(0).toUpperCase() + item.attribute.slice(1)+" of at least "+item.rating+".");
              }
            } else if (item.type === 'Skill') {
              if (item.skill == 'any') {
                var $sksp = $('ul.skill-specialties').find('input[type="hidden"][name$="_skill"]').map(function($x) {
                  return $x.val();
                }).get();
                var foundAny = false;
                $sksp.forEach(function(i) {
                  if ($('input[name="'+i+'"]').val() > item.rating) {
                    foundAny = true;
                  }
                });

                if (!foundAny) {
                  $item.addClass('error');
                  errors.push("Must have a skill with a specialty at at least "+item.rating+".");
                }
              } else if ($('input[name="' + item.skill + '"]').val() < item.rating) {
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
              var foundAny = false;
              item.options.forEach(function(optitem) {
                if (optitem.type === 'Merit') {
                  var $merit = $('ul.merits').find('input[type="hidden"][name$="_merit"]'+(optitem.merit.ID ? '[val="'+optitem.merit.ID+'"]' : '')).parents('li');
                  if ($merit.length > 0) {
                    var $rating = $merit.find('input[type="hidden"][name$="_rating"]'+(optitem.rating ? '[val="'+optitem.rating+'"]' : ''));
                    if ($rating && $rating.val() >= optitem.rating) {
                      foundAny = true;
                    }
                  }
                } else if (optitem.type === 'Attribute') {
                  if ($('input[name="'+optitem.attribute+'"]').val() >= optitem.rating) {
                    foundAny = true;
                  }
                } else if (optitem.type === 'Skill') {
                  if (optitem.skill == 'any') {
                    var $sksp = $('ul.skill-specialties').find('input[type="hidden"][name$="_skill"]').map(function($x) {
                      return $x.val();
                    }).get();
                    var fa = false;
                    $sksp.forEach(function(i) {
                      if ($('input[name="'+i+'"]').val() > optitem.rating) {
                        fa = true;
                      }
                    });

                    if (fa) {
                      foundAny = true;
                    }
                  } else if ($('input[name="' + optitem.skill + '"]').val() >= optitem.rating) {
                    foundAny = true;
                  }
                } else if (optitem.type === 'Skill Specialty') {
                  var $sksp = $('ul.skill-specialties').find('input[type="hidden"][name$="_skill"][val="'+optitem.skill_specialty+'"]').parents('li');
                  if ($sksp.length != 0) {
                    foundAny = true;
                  }
                }
              });
              if (!foundAny) {
                $item.addClass('error');
                var errorText = "Must have at least one of: "+item.options.map(function(m) {
                  if (m.type === 'Skill') {
                    return m.skill+" "+m.rating;
                  } else if (m.type === 'Attribute') {
                    return m.attribute+" "+m.rating;
                  } else if (m.type === 'Merit') {
                    return m.merit.post_title+(m.rating ? ' '+m.rating : '');
                  } else if (m.type === 'Skill Specialty') {
                    return "a specialty in "+m.skill_specialty;
                  }
                }).join(", ");
                errors.push(errorText);
              }
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
      var skillSpCount = $('.skill-specialties li:not([data-phantom="true"])').length;
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
      $('[name="willpower"]').val(amt);
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
      $('[name="health"]').val(amt);
      $('[name="current_health"]').val(currentstr);
    }

    function updateSpeed() {
      var spd =
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
          if ($("ul.merits > li").length > 0) {
            newNum = $("ul.merits > li").length;
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
            "' class='merit-id' /><input type='hidden' class='merit-rating' name='merits_" +
            newNum +
            "_rating' value='" +
            data.ratings[0] +
            "' /><input type='hidden' class='merit-spec' name='merits_" +
            newNum +
            "_specification' value='' /><input type='hidden' class='merit-desc' name='merits_" +
            newNum +
            "_description' value='' /></li>";
          $("ul.merits").append(newItem);
          $('[name="merits"]').val($("ul.merits > li").length);
          checkMerits();
        },
      });
    });

    $(".merits").on("click touchend", ".edit", function () {
      var merit = parseInt($(this)
        .parents("li")
        .find(".merit-id")
        .val());
      var currentVal = parseInt($(this)
        .parents("li")
        .find(".merit-rating")
        .val());
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
          $('#modal-content textarea').trumbowyg('empty');
          if (data.has_description) {
            $("#modal-content #description-row").show();
            $('#modal-content #description').trumbowyg('html', currentDesc);
            $("#modal-content #description").val(currentDesc);
          } else {
            $("#modal-content #description-row").hide();
            $('#modal-content #description').trumbowyg('html', '');
            $("#modal-content #description").val("");
          }
          $("#modal-content select").empty();
          $("#modal-content h4").text(data.name);
          $("#modal-content .description").html(
            data.description
          );
          $("#modal-content .prerequisites").html(
            "<strong>Prerequsites:</strong> " +
            data.prerequisites
          );
          if (!data.prerequisites) {
            $('#modal-content .prerequisites').hide();
          } else {
            $('#modal-content .prerequisites').show();
          }
          if (data.has_specification) {
            $("#modal-content #specification-row").show();
            $("#modal-content #specification").val(currentSpec);
          } else {
            $("#modal-content #specification-row").hide();
          }
          var $benefits = $('#modal-content #benefits-row');
          $benefits.html("");
          if (data.additional_benefits) {
            data.additional_benefits.forEach(function(b, i) {
              b.benefits.forEach(function(benefit, j) {
                if (benefit["player-defined"] === true) {
                  var name = 'benefit_definition_'+b.rating+'_'+j;
                  var res = name.match(/benefit_definition_([0-9]+)_([0-9]+)/);
                  var newname = "merits_" + idx + "_benefit_def_" + res[1] + "_" + res[2];
                  var val = $('[name="'+newname+'"]').val();
                  var skills_list = $('#skills_list').html();
                  var newItem = "";
                  if (benefit.type == 'Skill Specialty') {
                    newItem += "<div class='form-row' data-rating'"+b.rating+"'>";
                    newItem += "<label for='benefit_definition_"+b.rating+"_"+j+"_skill'>Skill</label>";
                    newItem += "<select name='benefit_definition_"+b.rating+"_"+j+"_skill'>";
                    newItem += skills_list;
                    newItem += "</select>"
                    newItem += "</div>";
                  }
                  newItem += "<div class='form-row' data-rating='"+b.rating+"'>";
                  newItem += "<label for='benefit_definition_" + b.rating + "_" + j + "'>" + (benefit.type == 'Merit' ? benefit.merit.post_title : benefit.type) + "</label>";
                  newItem += "<input type='text' name='benefit_definition_" + b.rating + "_" + j + "' value='"+val+"' />";
                  newItem += "</div>";
                  $benefits.append(newItem);
                }
              });
            });
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
              (currentVal == data.ratings[i] ?
                ' selected="selected"' :
                "") +
              ">" +
              data.ratings[i] +
              "</option>";
            $("#modal-content select#ratings").append(option);
          }
          $('#modal-content #benefits-row .form-row').each(function() {
            var rowRating = parseInt($(this).data('rating'));
            if (rowRating > currentVal) {
              $(this).hide();
            } else {
              $(this).show();
            }
          });
          $('#modal-content select').on('change', function() {
            var newVal = parseInt($(this).find('option:selected').val());
            $('#modal-content #benefits-row .form-row').each(function () {
              var rowRating = $(this).data('rating');
              if (rowRating > newVal) {
                $(this).hide();
              } else {
                $(this).show();
              }
            });
          });
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

    $("body").on("click touchend", "#save-merit", function () {
      var rating = $(".modal #ratings option:selected").val();
      var specification = $(".modal #specification").val();
      var description = $(".modal #description").trumbowyg('html');
      var idx = $(".modal #modal-content").data("index") + 1;
      $('.merits > li:nth-child(' + idx + ') > .label > .merit-rating').val(rating);
      $(".merits > li:nth-child(" + idx + ") > .label > .rating").text(
        rating
      );
      if ($('.modal #specification-row').is(":visible")) {
        $(".merits > li:nth-child(" + idx + ") > .label > .specification").text("(" + specification + ")");
        $('.merits > li:nth-child(' + idx + ') > .label > .merit-spec').val(specification);
      }
      if ($(".modal #description-row").is(":visible")) {
        $(".merits > li:nth-child(" + idx + ") > .label > .description").text(description);
        $('.merits > li:nth-child(' + idx + ') > .label > .merit-desc').val(description);
      }
      $('.skill-specialties li[data-phantom]').detach();
      $('#modal-content [name^="benefit_definition_"]').each(function() {
        var name = $(this).attr('name');
        var res = name.match(/benefit_definition_([0-9]+)_([0-9\_a-z]+)/);
        var newname = "merits_"+(idx-1)+"_benefit_def_"+res[1]+"_"+res[2];
        $('[name="'+newname+'"]').val($(this).val());
        if (!res[2].match("_skill")) {
          $('[name="' + newname + '"]').siblings('.specification').text(" ("+$(this).val()+") ");
        } else {
          var sibname = newname.replace("_skill", "");
          var newli = "<li data-phantom='true'><strong>"+$(this).val()+":</strong> "+$('[name="'+sibname+'"]').val()+"</li>";
          $('.skill-specialties').append(newli);
        }
      });
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
          $('ul.merits > li').each(function(i, elt) {
            $(elt).find('input[name$="_merit"]').attr("name", "merits_"+i+"_merit");
            $(elt).find('input[name$="_rating"]').attr("name", "merits_"+i+"_rating");
            $(elt).find('input[name$="_specification"]').attr("name", "merits_"+i+"_specification");
            $(elt).find('input[name$="_description"]').attr("name", "merits_"+i+"_description");
          });
        $('[name="merits"]').val($("ul.merits > li").length);
        checkMerits();
      }
      return false;
    });

    $("#add-specialty").on("click", function () {
      var skill = $("#skills_list option:selected").val();
      var specialty = $("#specialty_name").val();
      var num = $(".skill-specialties li:not([data-phantom])").length;
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
        $("ul.skill-specialties li:not([data-phantom])").length
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
        $('ul.skill-specialties li:not([data-phantom])').each(function(i, elt) {
          $(elt).find('input[name$="_skill"]').attr("name", "skill_specialties_"+i+"_skill");
          $(elt).find('input[name$="_specialty"]').attr("name", "skill_specialties_"+i+"_specialty");
        });
        $('[name="skill_specialties"]').val(
          $("ul.skill-specialties li:not([data-phantom])").length
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
        $('ul.conditions li').each(function(i, elt) {
          $(elt).find('input[name$="_condition"]').attr("name", "conditions_"+i+"_condition");
          $(elt).find('input[name$="_note"]').attr("name", "conditions_"+i+"_note");
        });
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
      if ($('#attribute-row .warn').length > 0) {
        return false;
      }

      return true;
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

      if ($('#skills-row .warn').length > 0) {
        return false;
      }

      return true;
    }

    $('#attributes-row input').on('change', function() {
      checkAttributes();
    });

    $('#skills-row input').on('change', function() {
      checkSkills();
    });

    function checkQuestionnaire()
    {
      var ok = true;
      $('#questionnaire textarea').each(function() {
        if ($(this).val() == '') {
          ok = false;
        }
      });
      return ok;
    }

    function checkIntegrity()
    {
      if ($('[name="integrity"]').val() > 0) {
        return true;
      }
      return false;
    }

    $(window).on('load', function() {
      $('.dots').each(function() {
        var val = parseInt($(this).find('input').val());
        if (val > 0) {
          $(this).find('i:nth-of-type('+val+')').addClass('fas').removeClass('far').nextAll().removeClass('fas').addClass('far');
        }
      });
      updateWillpower();
      updateHealth();
      checkAttributes();
      checkSkills();
      checkMerits();
      checkSkillSpecialties();
    });

    function validateSubmission()
    {
      var valid = true;
      // check virtue
      valid = valid && checkVirtue();
      // check vice
      valid = valid && checkVice();
      // check attributes
      valid == valid && checkAttributes();
      // check skills
      valid == valid && checkSkills();
      // check merits
      valid == valid && checkMerits();
      // check integrity
      valid == valid && checkIntegrity();
      // check skill specialties
      valid == valid && checkSkillSpecialties();
      // check questionnaire
      valid == valid && checkQuestionnaire();
      return valid;
    }

    $('#save-submit').on('click', function(e) {
      e.preventDefault();
      // validate first
      var valid = validateSubmission();
      $('input[name="status"]').val("Submitted");
      $('select[name="status"] option[value="Submitted"]').prop("selected", "selected").siblings().removeProp("selected");
      $(this).parents('form').submit();
    });
  },
}
