<!doctype html>
<html @php language_attributes() @endphp>
  @include('partials.head')
  <body @php body_class('dashboard') @endphp>
    <header>
      @yield('header')
    </header>
    <main class="main" id="app">
      @yield('content')
    </main>
    @php wp_footer() @endphp
  </body>
</html>
