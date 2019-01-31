@php
  global $post;
@endphp
<section id="intro" class="grey">
  <div class="wrapper">
    <div class="row top-xs">
      <div class="col-md-7 col-xs-12">
          <div class="box">
            <div class="content">
              @php(the_content())
            </div>
          </div>
        </div>
        <div class="col-md-5 col-xs-12 side-image">
          <img src="{{ get_the_post_thumbnail_url($post, 'large') }}" />
        </div>
      </div>
    </div>
  </div>
</section>
<section id="news" class="yellow">
  <div class="wrapper">
    <div class="row center-xs">
      <div class="col-xs-12">
        <h2>News &amp; Announcements</h2>
      </div>
    </div>
    <div class="row">
      @if(App\FrontPage::news())
        @foreach(App\FrontPage::news() as $post)
          @php(setup_postdata($post))
          <div class="col-md-6 col-xs-12">
            <div class="box">
              @include('partials.content')
            </div>
          </div>
        @endforeach
        @if(count(App\FrontPage::news()) % 2 == 1)
          <div class="col-md-6 col-xs-12 end-card">
            *
          </div>
        @endif
        @php(wp_reset_postdata())
      @endif
    </div>
  </div>
</section>
<section id="upcoming-events" class="grey">
  <div class="wrapper">
    <div class="row center-xs">
      <div class="col-xs-12">
        <h2>Upcoming Events</h2>
        @if(App\FrontPage::events())
          <dl class="events">
            @foreach(App\FrontPage::events() as $event)
              <dt><a href="{{ get_the_permalink($event->ID) }}">{{ get_the_title($event->ID) }}</a></dt>
              <dd>{{ get_field('date', $event->ID) }}</dd>
            @endforeach
          </dl>
        @else
          <p class="center">No upcoming events.</p>
        @endif
      </div>
    </div>
  </div>
</section>
