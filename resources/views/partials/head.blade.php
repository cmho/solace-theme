<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="theme-color" content="#333333" />
  <meta name="article:author" content="" />
  <script type="text/javascript">
    var ajaxurl = "{{ admin_url('admin-ajax.php') }}";
    var themepath = "{{ get_theme_file_uri() }}";
  </script>
  <link rel="manifest" href="{{ get_theme_file_uri() }}/manifest.json">
  @php wp_head() @endphp
</head>
