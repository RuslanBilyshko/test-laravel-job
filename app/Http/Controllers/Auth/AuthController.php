<?php namespace App\Http\Controllers\Auth;

use App\Modules\Forms\Forms;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\ConfirmUsers;
use Auth;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
  public function __construct()
  {
    $this->middleware('guest', ['except' => 'getLogout']);
  }

  public function getLogin($token = null)
  {
    $this->title = trans('app.auth');

    $data_form = [
      'email' => [
        'id' => 'email',
        'type' => 'email',
      ],
      'password' => [
        'id' => 'password',
        'type' => 'password',
      ],
    ];

    if($token)
      $data_form['confirm_token'] = [
        'id' => 'confirm_token',
        'type' => 'hidden',
        'value' => $token,
      ];

    $data_form['button'] = Forms::buttonLogin();

    $loginForm = Forms::get([
      'action' => route('postLogin'),
      'id' => 'login',
      'data' => $data_form,
    ]);

    $this->addContent($loginForm);

    return $this->draw();
  }

  /**
   * Обработка попытки аутентификации
   *
   * @return Response
   */
  public function postLogin(Request $request)
  {
    //dd($request);
    if($request->confirm_token)
    {
      $token = $request->confirm_token;
      $model = ConfirmUsers::where('token','=',$token)->firstOrFail();
      $user = User::where('email','=',$model->email)->first();
      $user->remember_token = $request->_token;
      $user->status = 1; // меняем статус на 1
      $user->save();  // сохраняем изменения
      $model->delete(); //Удаляем запись из confirm_users
    }

    $data_request = [
      'email' => $request->email,
      'password' => $request->password,
    ];

    if (Auth::attempt($data_request))
    {
      return redirect()->route('account',[Auth::user()->id]);
    }
    else
    {
      setMessage(trans('app.getLoginErrorDataMes'),false);
      return redirect()->route('getLogin');
    }

  }

  public function getLogout()
  {
    Auth::logout();
    return redirect()->route('getLogin');
  }

  public function getRegister()
  {
    $this->title = trans('app.getRegisterNewUser');

    $loginForm = Forms::get([
      'action' => route('postRegister'),
      'id' => 'register',
      'data' => [
        'email' => [
          'id' => 'email',
          'label' => trans('app.email'),
          'type' => 'email',
          'description' => trans('app.regDescription'),
        ],
        'button' => Forms::buttonRegister(),
      ]
    ]);

    $this->addContent($loginForm);

    return $this->draw();
  }

  public function postRegister(Request $request)
  {
    $this->validate($request, [
      'email' => 'required|email|max:255|unique:users',
    ]);

    //Insert user
    $password = str_random(8);
    $user = User::create([
      'email' => $request->input('email'),
      'password' => bcrypt($password),
    ]);

    if($user)
    {
      $email = $user->email;  //это email, который ввел пользователь
      $token = str_random(32); //это наша случайная строка
      $model= new ConfirmUsers; //создаем экземпляр нашей модели
      $model->email=$email; //вставляем в таблицу email
      $model->token=$token; //вставляем в таблицу токен
      $model->save();      // сохраняем все данные в таблицу

      $mail_data = [
        'email' => $user->email,
        'tocken' => $token,
        'password' => $password,
      ];

      Mail::send('emails.confirm',$mail_data,function($u) use ($user)
      {
        $u->from('admin@site.ru');
        $u->to($user->email);
        $u->subject('Confirm registration');
      });

      setMessage(trans('app.SendPassMess',['email' => $request->email]));
      return redirect()->route('getLogin',['confirm_token' => $token]);
    }


  }


}