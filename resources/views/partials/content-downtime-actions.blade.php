@php
  $user = wp_get_current_user();
@endphp
<div class="button-row right">
  <a href="{{ App\App::newDowntimeLink() }}" class="button">New Action</a>
</div>
@foreach(App\Downtimes::listDowntimes() as $game=>$downtimes)
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
        @php
          $char = get_post(get_field['character']);
        @endphp
        <h4>{{ $downtime->post_title }}</h4>
        <p class="character"><strong>Character:</strong> {{ $char->post_title }}</p>
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
