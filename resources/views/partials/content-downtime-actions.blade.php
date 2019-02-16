@php
  $user = wp_get_current_user();
@endphp
@if(App\App::currentDowntimePeriod())
  <div class="button-row right">
    <a href="{{ App\App::newDowntimeLink() }}" class="button">New Action</a>
  </div>
@endif
@foreach(App\Downtimes::listDowntimes() as $game=>$downtimes)
  @php
      $gamepost = get_post($game);
  @endphp
  <h3 id="{{ $gamepost->post_name }}">{{ $gamepost->post_title }}</h3>
  @if(date('Y-m-d') >= get_field('downtimes_open', $game) && date('Y-m-d') <= get_field('downtimes_close', $game))
      <p class="downtime-status">Downtimes are currently <strong>open</strong>. They will close at 11:59 PM on {{ date('m/d/y', strtotime(get_field('downtimes_close', $game))) }}.</p>
  @endif
  @if($downtimes)
    @foreach($downtimes as $downtime)
      <div class="downtime">
        @php
          $char = get_post(get_field('character', $downtime->ID)->ID);
        @endphp
        <h4>{{ $downtime->post_title }}</h4>
        <p class="character"><strong>Character:</strong> {{ $char->post_title }}</p>
        <p class="assets"><strong>Assets:</strong> {{ get_field('assets', $downtime) }}</p>
        <p class="goal"><strong>Goal:</strong> {{ get_field('goal', $downtime) }}</p>
        <div class="description">
          {!! get_field('description', $downtime) !!}
        </div>
        @if(get_field('response', $downtime) && get_field('downtimes_visible', $gamepost))
          <hr />
          <div class="response">
              {!! get_field('response', $downtime) !!}
          </div>
        @endif
        @if(App\App::isAdmin())
          <a href="{{ get_the_permalink($downtime) }}/#response">{{ (get_field('response', $downtime)) ? 'Edit Response' : 'Respond' }}</a>
        @endif
      </div>
    @endforeach
  @else
    <p><em>No downtimes for this game.</em></p>
  @endif
@endforeach
