<div class="block-wrapper {{$classes}}">
  @if($title)
    <h3 class="block-title">{{$title}}</h3>
  @endif
    @foreach ($fields as $field)
      {!! $field !!}
    @endforeach

</div>
