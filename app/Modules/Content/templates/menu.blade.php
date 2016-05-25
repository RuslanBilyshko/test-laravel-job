<nav class="menu {{$class_menu}}">
  <ul>
    @foreach($items as &$item)
      <li>
        <a class="{{$item['class']}}"
             @if($item['title']) title="{{$item['title']}}" @endif
             href="{{$item['href']}}">{!! $item['text'] !!}</a>
      </li>
    @endforeach
  </ul>
</nav>