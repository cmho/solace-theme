<li>
  <a href="#"><strong>{{ get_the_title($equipment['item']->ID) }}</strong></a>
  <dl>
      <dt>Type</dt>
      <dd>{{ ucfirst(get_field('type', $equipment['item']->ID)) }}</dd>
      @if(get_field('size', $equipment['item']->ID))
        <dt>Size</dt>
        <dd>{{ get_field('size', $equipment['item']->ID) }}</dd>
      @endif
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
      @if(get_field('clip_size', $equipment['item']->ID))
        <dt>Clip Size</dt>
        <dd>@php(\App\Character::printSquares(get_field('clip_size', $equipment['item']->ID)))</dd>
      @endif
      @if(get_field('general_armor', $equipment['item']->ID))
        <dt>General Armor</dt>
        <dd>{{ get_field('general_armor', $equipment['item']->ID) }}</dd>
      @endif
      @if(get_field('ballistic_armor', $equipment['item']->ID))
        <dt>Ballistic Armor</dt>
        <dd>{{ get_field('ballistic_armor', $equipment['item']->ID) }}</dd>
      @endif
      @if(get_field('defense', $equipment['item']->ID))
        <dt>Defense</dt>
        <dd>{{ get_field('defense', $equipment['item']->ID) }}</dd>
      @endif
      @if(get_field('speed', $equipment['item']->ID))
        <dt>Speed</dt>
        <dd>{{ get_field('speed', $equipment['item']->ID) }}</dd>
      @endif
      @if(get_field('cost', $equipment['item']->ID))
        <dt>Cost</dt>
        <dd>{{ get_field('cost', $equipment['item']->ID) }}</dd>
      @endif
      @if(get_field('qualities', $equipment['item']->ID))
        <dt>Qualities</dt>
        <dd>{{ join(", ", get_field('qualities', $equipment['item']->ID)) }}</dd>
      @endif
      @if($equipment['note'])
        <dt>Notes</dt>
        <dd>{!! $equipment['note'] !!}</dd>
      @endif
  </dl>
</li>
