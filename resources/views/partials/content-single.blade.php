<section class="grey">
  <div class="wrapper">
    <div class="row">
      <div class="col-md-4 col-xs-12">
        <h2>{{ get_the_title() }}</h2>
        <p class="date">{{ get_the_date() }}</p>
        <p>&lt; <a href="{{ get_the_permalink(get_option('page_for_posts')) }}">View More Updates</a></p>
      </div>
      <article @php post_class('col-md-8 col-xs-12') @endphp>
        <div class="box">
          <div class="content">
            @php(the_content())
            {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
