<?php namespace App\Http\Controllers;

use App\Modules\Content\Field;
use App\UserAccounts;
use Illuminate\Http\Request;
use App\Modules\Content\Block;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
	private $user;

	public function __construct()
	{
		parent::__construct();
		$this->user = Auth::user();
	}

  public function index($id)
  {
    $this->title = trans('app.userPage');
    $user = UserAccounts::findAccount($id);

    if(isset($user['avatar']))
    {
      $img = array_pull($user,'avatar');
      $avatar = new Avatar();
      $fieldImg = new Field();
      $res = $fieldImg->paragraf($avatar->getImg('avatar',$img));
      $this->addContent($res);
    }


    $this->addContent(Block::make($user));
    $this->addContent(renderLink(route('accountEdit'),['text' => trans('app.edit')]));
    return $this->draw();

  }

  public function edit()
  {
	  $form = new UserAccountController();
    $this->title = trans('app.editUser');
    $this->addContent(renderLink(route('passwordSet'),['text' => trans('app.passwordReplace')]));
    $this->addContent($form->getForm($this->user->id, $this->user->status));
    return $this->draw();
  }

  public function update(Request $request)
  {
	  if($request->cancel)
		  return redirect(route('account',[$this->user->id]));

    $regexPhone = "/^[0-9+\\-)( ]*$/";
    $this->validate($request,[
      'name' => 'sometimes|required|min:3',
      'first_name' => 'sometimes|required|min:3',
      'phone' => 'sometimes|required|min:5|regex:'.$regexPhone,
	    'number' => 'sometimes|required_with:month,year',
	    'month' => 'sometimes|required_with:number,year',
	    'year' => 'sometimes|required_with:month,number',
	    'img' => 'sometimes|max:2000|mimes:jpg,jpeg,png',
    ]);

	  $account = new UserAccountController();

	  $redirect_route = route('account',[$this->user->id]);

	  if($this->user->status == config('user.status.one'))
	  {
		  $account->firsFormUpdate($request);
		  $this->user->update(['status' => config('user.status.two')]);
		  $redirect_route = route('accountEdit');
	  }
	  elseif($this->user->status == config('user.status.two'))
		  $account->secondFormUpdate($request);

    if($request->password)
      $this->passwordReplace($request->password);

    setMessage(trans('app.storeMessage'));
    return redirect($redirect_route);
  }




}