<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PageController;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class PasswordController extends Controller {

  /*
  |--------------------------------------------------------------------------
  | Password Reset Controller
  |--------------------------------------------------------------------------
  |
  | This controller is responsible for handling password reset requests
  | and uses a simple trait to include this behavior. You're free to
  | explore this trait and override any methods you wish to tweak.
  |
  */

  use ResetsPasswords;

  private $page;
  protected $redirectPath = '/';

  /**
   * Create a new password controller instance.
   *
   * @param  \Illuminate\Contracts\Auth\Guard  $auth
   * @param  \Illuminate\Contracts\Auth\PasswordBroker  $passwords
   * @return void
   */
  public function __construct(Guard $auth, PasswordBroker $passwords)
  {
    $request = new Request();
    $this->page = new PageController($request);

    $this->auth = $auth;
    $this->passwords = $passwords;

    $this->middleware('guest');
  }

  public function getEmail()
  {
    $content =  view('auth.password');

    $page = [
      'title' => trans('app.passwordReset'),
      'content' => $content,
      'page_width' => 6,
    ];

    return $this->page->render($page);
  }

  public function getReset($token = null)
  {
    if (is_null($token))
    {
      throw new NotFoundHttpException;
    }

    $content =  view('auth.reset')->with('token', $token);

    $page = [
      'title' => trans('app.passwordReset'),
      'content' => $content,
      'page_width' => 6,
    ];

    return $this->page->render($page);
  }



}
