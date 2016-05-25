<input id="{{$id}}" name="{{$id}}" class="{{$class}}"

       @if($onclick)
            onclick="{{$onclick}}"
       @endif

       @if($disabled)
            disabled="disabled"
       @endif

       @if(old($id) || $errors->first($id))
            value="{{old($id)}}"
       @elseif($value)
            value="{{$value}}"
       @endif

       @if($size)size="{{$size}}"@endif

       type="{{$type}}"

       @if($placeholder)
        placeholder="{{$placeholder}}"
       @endif

       @if($size)
        style="width:{{$size}}%"
       @endif
    >

<?=$errors->first($id, '<div class="error">:message</div>')?>

