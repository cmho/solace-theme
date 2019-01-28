<h3>Equipment</h3>
<p><em>Please request equipment through the Storytellers.</em></p>
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
            <dt>Durability</dt>
            <dd>{{ get_field('durability', $equipment['item']->ID) }}</dd>
            <dt>Qualities</dt>
            <dd>{{ join(", ", get_field('qualities', $equipment['item']->ID)) }}</dd>
            <dt>Notes</dt>
            <dd>{{ $equipment['note'] }}</dd>
        </dl>
        </li>
        @endforeach
    </ul>
@else
    <p><em>None</em></p>
@endif
