<div class="form-group form-item form-item-{{$id}} {{$field_width}}">
    @if($label)
        <label for="{{$id}}"  @if($label_class)class="{{$label_class}}"@endif>{{$label}}@if($required)<span class="field-required" title="{{trans('app.fieldRequired')}}">*</span>@endif</label>
    @endif
    {!! $field !!}

        @if($type == 'text' || $type == 'select' || $type == 'radio')
            <span class="ok"></span>
        @endif

    @if($description)
        <div class="description help-block">{{$description}}</div>
    @endif
</div>