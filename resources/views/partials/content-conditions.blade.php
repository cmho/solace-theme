<h3>Conditions</h3>
<label for="conditions_list">Condition</label>
<select id="conditions_list">
  @foreach(App\Conditions::list() as $condition)
    <option value="{{ $condition->ID }}">{{ get_the_title($condition->ID)}}</option>
  @endforeach
</select>
<label for="condition_note">Note</label>
<input type="text" name="condition_note" />
<button type="button" id="add-condition">Add</button>
@if(get_field('conditions'))
  <ul>
    @foreach(get_field('conditions') as $condition)
    <li><strong>{{ get_the_title($condition['condition']->ID) }}</strong><br />
      {{ $condition['note'] }}
    </li>
    @endforeach
  </ul>
@endif
