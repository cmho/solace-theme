<h3>Conditions</h3>
<label for="conditions_list">Condition</label>
<select id="conditions_list">
  @foreach(App\Conditions::list() as $condition)
    <option value="{{ $condition->ID }}">{{ get_the_title($condition->ID)}}</option>
  @endforeach
</select>
<label for="condition_note">Note</label>
<input type="text" name="condition_note" id="condition_note" />
<button type="button" id="add-condition">Add</button>
<input type="hidden" name="conditions" val="{{ count(get_field('conditions')) }}" />
<ul class="conditions">
  @if(get_field('conditions'))
    @foreach(get_field('conditions') as $i=>$condition)
    <li><strong>{{ get_the_title($condition['condition']->ID) }}</strong> <button class="delete" type="button"><i class="fas fa-trash"></i><span class="sr-only">Delete</span></button><br />
      {{ $condition['note'] }}
      <input type="hidden" name="conditions_{{ $i }}_condition" value="{{ $condition['condition']->ID }}" />
      <input type="hidden" name="conditions_{{ $i }}_note" value="{{ $condition['note'] }}" />
    </li>
    @endforeach
  @endif
</ul>
