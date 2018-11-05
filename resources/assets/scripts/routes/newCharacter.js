export default {
  init() {
    $('.dots i.fa-circle').on('click', function() {
      $(this).nextAll('i.fa-circle').removeClass('fas').addClass('far');
      if ($(this).hasClass('far')) {
        $(this).addClass('fas').removeClass('far');
        $(this).prevAll('i.fa-circle').removeClass('far').addClass('fas');
      } else {
        $(this).removeClass('fas').addClass('far');
      }
    });
  },
  finalize() {

  },
};
