@php
  $backstory = get_field_object('backstory');
@endphp

<label for="backstory">{{ $backstory['label'] }}</label>
<p class="help">Maximum 500 words.</p>
<textarea name="backstory">{!! get_field('backstory') !!}</textarea>
<label for="connections">List 3 connections to other characters, PCs or NPCs.</label>
<p class="help">Minimum 3 connections; please list character name, player name, and a brief description of the nature of that connection.</p>
<textarea name="connections">{!! get_field('connections') !!}</textarea>
<label for="complications">Complications</label>
<p class="help">A list of secrets, vices, and obligations that complicate your character's life. We may suggest some of these be turned into Persistent Conditions.</p>
<textarea name="complications">{!! get_field('complications') !!}</textarea>
<label for="supernatural">What was your first experience with the supernatural? Which supernatural experience most shaped your worldview?</label>
<textarea name="supernatural">{!! get_field('supernatural') !!}</textarea>
<label for="massacre">Where were you when the massacre took place? Who did you lose?</label>
<textarea name="massacre">{!! get_field('massacre') !!}</textarea>
<label for="survive">What is the worst thing you've done to survive?</label>
<textarea name="survive">{!! get_field('survive') !!}</textarea>
<label for="loss">What loss have you never gotten over, or that hurt the most?</label>
<textarea name="loss">{!! get_field('loss') !!}</textarea>
<label for="hobbies">What's one thing you hold onto outside of your hunter life?</label>
<textarea name="hobbies">{!! get_field('hobbies') !!}</textarea>
<label for="coping">What do you do to cope with the stresses of this life?</label>
<textarea name="coping">{!! get_field('coping') !!}</textarea>
<label for="anything_else">OPTIONAL: Is there anything else the Storytellers should know about this character?</label>
<textarea name="anything_else">{!! get_field('anything_else') !!}</textarea>
