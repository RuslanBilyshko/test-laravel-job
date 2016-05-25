<nav class="menu user-menu">
  <ul>
    @if (Auth::guest())
      <li><a class="btn btn-primary" href="{{route('getLogin')}}">{{trans('app.getLogin')}}</a></li>
      <li><a class="btn btn-success" href="{{route('getRegister')}}">{{trans('app.getRegister')}}</a></li>
    @else
      <li><a class="btn btn-default" href="{{route('account',[Auth::user()->id])}}">
          <i class="fa fa-user" aria-hidden="true"></i>
          {{trans('app.userProfile')}}</a>
      </li>
      <li>
        <a class="btn btn-default"  href="{{route('logout')}}">
          <i class="fa fa-sign-out" aria-hidden="true"></i>
          {{trans('app.logout')}}
        </a>
      </li>
    @endif
  </ul>
</nav>