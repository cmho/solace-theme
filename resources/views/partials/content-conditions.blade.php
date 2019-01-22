<h3>Conditions</h3>
@if(get_field('conditions'))
  <ul>
    @foreach(get_field('conditions') as $condition)
    <li><strong>{{ get_the_title($condition['condition']->ID) }}</strong><br />
      {{ $condition['note'] }}
    </li>
    @endforeach
  </ul>
@endif
