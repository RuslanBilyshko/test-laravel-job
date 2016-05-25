@if(Session::has('message'))
  <div class="message">
    <p class="bg-{!!Session::get('message_status')!!}">{!!Session::get('message')!!}</p>
  </div>
@endif