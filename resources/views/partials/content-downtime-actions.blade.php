@php
  $user = wp_get_current_user();
  $char = get_posts(array(
    'post_type' => 'character',
    'posts_per_page' => 1,
    'orderby' => 'date_modified',
    'order' => 'DESC',
    'meta_input' => array(
      array(
        'key' => 'status',
        'value' => 'Active'
      )
    )
  ));
  $character = $char[0];
@endphp
<div class="button-row right">
    <a href="#" class="button">New Action</a>
</div>
@foreach(App\Downtimes::listDowntimes($character->ID) as $game=>$downtimes)
  @php
      $gamepost = get_post($game);
  @endphp
  <h3>{{ $gamepost->post_title }}</h3>
  @if(date('Ymd') >= get_field('downtimes_open', $game) && date('Ymd') <= get_field('downtimes_close', $game))
      <p class="downtime-status">Downtimes are currently <strong>open</strong>. They will close at 11:59 PM on {{ date('m/d/y', strtotime(get_field('downtimes_close', $game))) }}.</p>
  @endif
  @if($downtimes)
    @foreach($downtimes as $downtime)
      <div class="downtime">
        <h4>{{ $downtime->post_title }}</h4>
        <p class="assets"><strong>Assets:</strong> {{ get_field('assets', $downtime) }}</p>
        <p class="goal"><strong>Goal:</strong> {{ get_field('goal', $downtime) }}</p>
        <div class="description">
          {!! get_field('description', $downtime) !!}
        </div>
        @if(get_field('response', $downtime))
          <hr />
          <div class="response">
              {!! get_field('response', $downtime) !!}
          </div>
        @endif
        @if(App\App::isAdmin())
          <a href="{{ get_the_permalink($downtime) }}/?mode=respond">{{ (get_field('response', $downtime)) ? 'Edit Response' : 'Respond' }}</a>
        @endif
      </div>
    @endforeach
  @else
    <p><em>No downtimes for this game.</em></p>
  @endif
@endforeach
