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
            id: id
          },
          success: function(data) {
            charRow.fadeOut();
            charRow.detach();
          }
        });
      }
      return;
    })
  },
};
