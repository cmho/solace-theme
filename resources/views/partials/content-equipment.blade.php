<h3>Equipment</h3>
<p class="equipment-notice"><em>Please request equipment through the Storytellers.</em></p>
@if(get_field('equipment'))
    <ul class="equipment">
        @foreach(get_field('equipment') as $equipment)
        <li>
        <strong>{{ get_the_title($equipment['item']->ID) }}</strong><br />
        <dl>
            <dt>Type</dt>
            <dd>{{ get_field('type', $equipment['item']->ID) }}</dd>
            <dt>Size</dt>
            <dd>{{ get_field('size', $equipment['item']->ID) }}</dd>
            @if(get_field('durability', $equipment['item']->ID))
              <dt>Durability</dt>
              <dd>{{ get_field('durability', $equipment['item']->ID) }}</dd>
            @endif
            @if(get_field('damage', $equipment['item']->ID))
              <dt>Damage</dt>
              <dd>{{ get_field('damage', $equipment['item']->ID)}}</dd>
            @endif
            @if(get_field('initiative_modifier', $equipment['item']->ID))
              <dt>Initiative Modifier</dt>
              <dd>{{ get_field('initiative_modifier', $equipment['item']->ID)}}</dd>
            @endif
            @if(get_field('required_strength', $equipment['item']->ID))
              <dt>Required Strength</dt>
              <dd>{{ get_field('required_strength', $equipment['item']->ID) }}</dd>
            @endif
            @if(get_field('cost', $equipment['item']->ID))
              <dt>Cost</dt>
              <dd>{{ get_field('cost', $equipment['item']->ID) }}</dd>
            @endif
            @if(get_field('clip_size', $equipment['item']->ID))
              <dt>Clip Size</dt>
              <dd>@php(\App\Character::printSquares(get_field('clip_size', $equipment['item']->ID)))</dd>
            @endif
            <dt>Qualities</dt>
            <dd>{{ join(", ", get_field('qualities', $equipment['item']->ID)) }}</dd>
            <dt>Notes</dt>
            <dd>{!! $equipment['note'] !!}</dd>
        </dl>
        </li>
        @endforeach
    </ul>
@else
    <p><em>None</em></p>
@endif
