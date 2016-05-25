@foreach($data as $key => $value)
  <div class="radio">
    <label>
      <input name="{{$id}}"
        @if(((old($id) && $key == old($id)) || $key == $selected) && !$errors->first($id))
          checked="checked"
        @endif

          value="{{$key}}"
          type="radio"/>

          <span>{{Lang::has('app.'.$value) ? trans('app.'.$value) : $value}}</span>


      </label>
    </div>
@endforeach

<?=$errors->first($id, '<div class="error">:message</div>')?>

