<header class="header">
<h1><a href="{{ home_url('/') }}">{{ get_bloginfo('name', 'display') }}</a></h1>
  <p class="desc">An Urban Fantasy Horror LARP</p>
  <nav class="nav-primary">
      @if (has_nav_menu('primary_navigation'))
        {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']) !!}
      @endif
    </nav>
  <img src="{{ get_theme_file_uri() }}/dist/images/header.jpg" id="header-img" />
</header>
