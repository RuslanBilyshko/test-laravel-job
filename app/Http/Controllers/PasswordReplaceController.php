<?php namespace App\Http\Controllers;

use App\ConfirmUsers;
use App\Modules\Forms\Forms;
use App\PasswordReplace;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PasswordReplaceController extends Controller
{
  private $user;

  public function __construct()
  {
    parent::__construct();
    $this->user = Auth::user();
  }

  public function set()
  {
    //Field Password
    $fields[] = Forms::field([
      'id' => 'password',
      'label' => trans('app.password'),
      'type' => 'password',
      'required' => false,
    ]);

    //Field password_confirmation
    $fields[] = Forms::field([
      'id' => 'password_confirmation',
      'label' => trans('app.password_confirmation'),
      'type' => 'password',
      'description' => trans('app.confirmedViaEmail'),
      'required' => false,
    ]);

    $fields[] = Forms::buttonSave();
    $fields[] = Forms::buttonCancel();

    $form = Forms::get([
      'id' => 'edit-password',
      'action' => route('passwordSend'),
      'fields' => $fields,
    ]);

    $this->title = trans('app.passwordReplace');
    $this->addContent($form);
    return $this->draw();
  }

  public function send(Request $request)
  {
    if($request->cancel)
      return redirect(route('account',[$this->user->id]));

    $this->validate($request,[
      'password' => 'required|required_with:password_confirmation|min:4|confirmed',
      'password_confirmation' => 'required_with:password|same:password',
    ]);

    $user = $this->user;
    $token = $user->remember_token;
    $password = bcrypt($request->password);
    $model = PasswordReplace::firstOrNew(['remember_token' => $token]);
    $model->password = $password;
    $model->save();

    $mail_data = [
      'email' => $user->email,
      'token' => $token,
    ];

    Mail::send('emails.password-replace',$mail_data,function($u) use ($user)
    {
      $u->from('admin@site.ru');
      $u->to($user->email);
      $u->subject('Изменение пароля');
    });

    setMessage(trans('app.passwordSendMess'));
    return redirect()->route('account',[$this->user->id]);
  }

  public function replace(Request $request)
  {
    //dd($request->token);

    if($request->token)
    {
      $token = $request->token;
      $model = PasswordReplace::where('remember_token','=',$token)->firstOrFail();
      $user = User::where('remember_token','=',$token)->first();

      if($model && $user)
      {
        $user->password = $model->password;
        $user->save();
        $model->delete();
        setMessage(trans('app.passwordReplaceSucces'));
      }
      else
      {
        setMessage(trans('app.tokenFromPassReplaceError',false));
      }

      return redirect()->back();
    }
  }
}