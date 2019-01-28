@foreach(App\Character::questionnaire() as $q)
  <div class="form-row">
    <label for="backstory">{{ $q['label'] }}</label>
    @if($q['instructions'])
      <p class="help">{{ $q['instructions'] }}</p>
    @endif
    <textarea name="{{ $q['name'] }}" rows="6">{!! get_field($q['name']) !!}</textarea>
</div>
@endforeach
