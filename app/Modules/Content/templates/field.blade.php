<div class="field field-{{$name}}">
  @if(Lang::has('app.'.$label))
    <span class="field-label">{{trans('app.'.$label)}}:</span>
  @endif
  <span class="field-item">{{$value}}</span>
</div>