<textarea id="{{$id}}" name="{{$id}}" cols="{{$cols}}" rows="{{$rows}}" class="{{$class}}">@if(old($id) || $errors->first($id)){{old($id)}}@elseif($value){{$value}}@endif
</textarea>