<!doctype html>
<html @php language_attributes() @endphp>
  @include('partials.head')
  <body @php body_class() @endphp>
    <svg class="defs-only">
      <filter id="duochrome" color-interpolation-filters="sRGB" x="0" y="0" height="100%" width="100%">
        <feColorMatrix id="matrix" type="matrix" values="0.79296875 0 0 0 0.19921875 0.75390625 0 0 0 0.19921875 0.4765625 0 0 0 0.19921875 0 0 0 1 0"></feColorMatrix>
      </filter>
    </svg>
    @php do_action('get_header') @endphp
    @include('partials.header')
    <main class="main">
      @yield('content')
    </main>
    @if (App\display_sidebar())
      <aside class="sidebar">
        @include('partials.sidebar')
      </aside>
    @endif
    @php do_action('get_footer') @endphp
    @include('partials.footer')
    @php wp_footer() @endphp
  </body>
</html>
