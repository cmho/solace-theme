<!doctype html>
<html @php language_attributes() @endphp>
  @include('partials.head')
  <body @php body_class('print') @endphp>
    <main class="main">
      @yield('content')
    </main>
    @php wp_footer() @endphp
  </body>
</html>
