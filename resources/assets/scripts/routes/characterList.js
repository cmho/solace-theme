export default {
  init() {
    $(document).on('ready', function() {
      $('.datatable').DataTable();
    });

    $('.delete-link').on('click', function() {
      var charRow = $(this).parents('tr');
      var c = confirm('Are you sure you want to delete this character?');
      if (c) {
        var id = $(this).data('id');
        $.ajax({
          url: ajaxurl,
          method: 'POST',
          data: {
            action: 'delete_character',
            id: id,
          },
          success: function(data) {
            charRow.fadeOut();
            charRow.detach();
          },
        });
      }
      return;
    });

    $('#send-approvals-button').on('click', function(e) {
      e.preventDefault();
      $.ajax({
        url: ajaxurl,
        method: 'POST',
        data: {
          action: 'send_approvals'
        },
        success: function(data) {
          $(".flash").append(
            '<div class="message">Character approval emails sent. <a href="#" class="close"><i class="fas fa-times"></i><span class="sr-only">Close</span></a></div>'
          );
        }
      });
    });

    $('.flash').on('click', '.close', function(e) {
      e.preventDefault();
      $(this).parent('.message').detach();
    });
  },
};
