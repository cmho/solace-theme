@foreach(App\Character::questionnaire() as $q)
  <div class="form-row">
    <label for="backstory">{{ $q['label'] }}</label>
    @if($q['instructions'])
      <p class="help">{{ $q['instructions'] }}</p>
    @endif
    <textarea name="backstory" rows="6">{!! get_field($q['key']) !!}</textarea>
</div>
@endforeach
