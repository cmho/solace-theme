<h3>Equipment</h3>
<p><em>Please request equipment through the Storytellers.</em></p>
@if(get_field('equipment'))
    <ul>
        @foreach(get_field('equipment') as $equipment)
        <li>
        <strong>{{ get_the_title($equipment['equipment']->ID) }}</strong><br />
        <dl>
            <dt>Type</dt>
            <dd>{{ get_field('type', $equipment['equipment']->ID) }}</dd>
            <dt>Size</dt>
            <dd>{{ get_field('size', $equipment['equipment']->ID) }}</dd>
            <dt>Durability</dt>
            <dd>{{ get_field('durability', $equipment['equipment']->ID) }}</dd>
            <dt>Qualities</dt>
            <dd>{{ join(", ", get_field('qualities', $equipment['equipment']->ID)) }}</dd>
            <dt>Notes</dt>
            <dd>{{ $equipment['note'] }}</dd>
        </dl>
        </li>
        @endforeach
    </ul>
@else
    <p><em>None</em></p>
@endif