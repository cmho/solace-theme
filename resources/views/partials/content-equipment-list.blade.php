<li>
  <a href="#"><strong>{{ get_the_title($equipment['item']->ID) }}</strong></a>
  <dl>
      <dt>Type</dt>
      <dd>{{ ucfirst(get_field('type', $equipment['item']->ID)) }}</dd>
      @if(get_field('size', $equipment['item']->ID) != null)
        <dt>Size</dt>
        <dd>{{ get_field('size', $equipment['item']->ID) }}</dd>
      @endif
      @if(get_field('durability', $equipment['item']->ID) != null)
        <dt>Durability</dt>
        <dd>{{ get_field('durability', $equipment['item']->ID) }}</dd>
      @endif
      @if(get_field('damage', $equipment['item']->ID) != null)
        <dt>Damage</dt>
        <dd>{{ get_field('damage', $equipment['item']->ID)}}</dd>
      @endif
      @if(get_field('initiative_modifier', $equipment['item']->ID) != null)
        <dt>Initiative Modifier</dt>
        <dd>{{ get_field('initiative_modifier', $equipment['item']->ID)}}</dd>
      @endif
      @if(get_field('required_strength', $equipment['item']->ID) != null)
        <dt>Required Strength</dt>
        <dd>{{ get_field('required_strength', $equipment['item']->ID) }}</dd>
      @endif
      @if(get_field('clip_size', $equipment['item']->ID) != null)
        <dt>Clip Size</dt>
        <dd>@php(\App\Character::printSquares(get_field('clip_size', $equipment['item']->ID)))</dd>
      @endif
      @if(get_field('general_armor', $equipment['item']->ID) != null)
        <dt>General Armor</dt>
        <dd>{{ get_field('general_armor', $equipment['item']->ID) }}</dd>
      @endif
      @if(get_field('ballistic_armor', $equipment['item']->ID) != null)
        <dt>Ballistic Armor</dt>
        <dd>{{ get_field('ballistic_armor', $equipment['item']->ID) }}</dd>
      @endif
      @if(get_field('defense', $equipment['item']->ID) != null)
        <dt>Defense</dt>
        <dd>{{ get_field('defense', $equipment['item']->ID) }}</dd>
      @endif
      @if(get_field('speed', $equipment['item']->ID) != null)
        <dt>Speed</dt>
        <dd>{{ get_field('speed', $equipment['item']->ID) }}</dd>
      @endif
      @if(get_field('cost', $equipment['item']->ID) != null)
        <dt>Cost</dt>
        <dd>{{ get_field('cost', $equipment['item']->ID) }}</dd>
      @endif
      @if(get_field('qualities', $equipment['item']->ID) != null)
        <dt>Qualities</dt>
        <dd>{{ join(", ", get_field('qualities', $equipment['item']->ID)) }}</dd>
      @endif
      @if($equipment['notes'])
        <dt>Notes</dt>
        <dd>{!! $equipment['notes'] !!}</dd>
      @endif
  </dl>
</li>
