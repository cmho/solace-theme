<h3>Merits</h3>
<ul class="merits">
  @foreach(get_field('merits') as $merit)
    <li>{{ get_the_title($merit['merit']) }}{{ get_field('requires_specification', $merit['merit']) ? " (".$merit['specification'].")" : '' }}{{ count(get_field('allowed_ratings', $merit['merit'])) > 1 ? " ".$merit['rating'] : '' }}{{ $merit['description'] ? '<div>'.$merit['description'].'</div>' : '' }}</li>
  @endforeach
</ul>
