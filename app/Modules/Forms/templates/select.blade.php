<select name="{{$id}}"
        id="{{$id}}"
        class="{{$class}}"

        @if($disabled)
            disabled="disabled"
        @endif

        @if($size)
          style="width:{{$size}}%"
        @endif

        >
    <option value=""></option>
    @foreach($data as $key => $value)

        @if(old($id) && $key == old($id) && !$errors->first($id))
            <option value="{{$key}}" selected="selected">{{Lang::has('app.'.$value) ? trans('app.'.$value) : $value}}</option>
        @elseif(!old($id) && $key == $selected && !$errors->first($id))
            <option value="{{$key}}" selected="selected">{{Lang::has('app.'.$value) ? trans('app.'.$value) : $value}}</option>
        @else
            <option value="{{$key}}">{{Lang::has('app.'.$value) ? trans('app.'.$value) : $value}}</option>
        @endif

    @endforeach
</select>
<?=$errors->first($id, '<div class="error">:message</div>')?>