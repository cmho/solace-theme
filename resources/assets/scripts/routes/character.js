export default {
  init() {
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
      console.log(mentals);
      console.log(socials);
      console.log(physicals);

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
        console.log(primary_name);
        console.log(primary_val);
        console.log(secondary_name);
        console.log(secondary_val);
        console.log(tertiary_name);
        console.log(tertiary_val);
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
  },
}
