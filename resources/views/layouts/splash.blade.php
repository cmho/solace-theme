<!doctype html>
<html @php language_attributes() @endphp>
  @include('partials.head')
  <body @php body_class() @endphp>
    <svg class="defs-only">
      <filter id="duochrome" color-interpolation-filters="sRGB" x="0" y="0" height="100%" width="100%">
        <feColorMatrix id="matrix" type="matrix" values="0.79296875 0 0 0 0.19921875 0.75390625 0 0 0 0.19921875 0.4765625 0 0 0 0.19921875 0 0 0 1 0"></feColorMatrix>
      </filter>
    </svg>
    <header class="splash-header">
        <h1><a href="{{ home_url('/') }}">Solace</a></h1>
        <p class="subtitle">An Urban Fantasy Horror LARP</p>
    </header>
    <main class="main">
      @yield('content')
    </main>
    @php wp_footer() @endphp
  </body>
</html>
