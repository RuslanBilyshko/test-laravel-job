<div class="row">
  <div class="form-wrapper {{$class_wrapper}}">
    <form id="form-{{$id}}" @if($action)action="{{$action}}"@endif method="{{$method}}" @if($enctype)enctype="{{$enctype}}"@endif role="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      @foreach($fields as $field)
        {!! $field !!}
      @endforeach

    </form>
    <? //dd($errors) ?>
  </div>
</div>


