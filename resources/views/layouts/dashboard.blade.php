<!doctype html>
<html @php language_attributes() @endphp>
  @include('partials.head')
  <body @php body_class('dashboard') @endphp>
    <header>
      <h1><a href="{{ home_url('/') }}">{{ get_bloginfo('name', 'display') }}</a></h1>
    </header>
    <main class="main">
      @yield('content')
    </main>
    @php wp_footer() @endphp
  </body>
</html>
