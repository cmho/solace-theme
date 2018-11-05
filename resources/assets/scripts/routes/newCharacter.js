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
    });
  },
  finalize() {

  },
};
