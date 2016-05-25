<?php namespace App\Http\Controllers;

use App\City;
use App\Gender;
use App\Modules\Forms\Forms;
use App\UserAccounts;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserAccountController
{
  protected $dirName = 'avatar';
  private $w_img = 200;
  private $h_img = 175;
  private $avatar;

  public function __construct()
  {
    $this->avatar = new Avatar();
  }

	public function firstEditForm($id)
	{
		$fields = ['name','first_name','phone'];
		$account = UserAccounts::find($id,$fields);
		$account = $account ? $account->toArray() : null;
		$data = [];

		foreach($fields as $field)
		{
			$data[] = [
				'id' => $field,
				'label' => trans('app.'.$field),
				'value' => $account ? $account[$field] : null,
			];
		}

		$data[] = [
			'id' => 'uid',
			'type' => 'hidden',
			'value' => $id,
		];
		$data[] = Forms::buttonUpdate();

		return Forms::get([
			'id' => 'edit-account',
			'action' => route('accountUpdate',[$id]),
			'data' => $data,
		]);
	}

	public function secondEditForm($id)
	{
		$fillable = ['date','gender','city_id','avatar'];
		$account = UserAccounts::find($id,$fillable);
		$account = $account ? $account->toArray() : null;

		if($account['date'] != 0)
		{
			$dt = Carbon::createFromTimestamp($account['date']);
			$day = $dt->day;
			$month = $dt->month;
			$year = $dt->year;
		}
		else
		{
			$day = null;
			$month = null;
			$year = null;
		}

		//Field dateOfBirth
		$fields[] = Forms::label(trans('app.dateOfBirth'));
		$fields[] = Forms::selectForNumber($day);
		$fields[] = Forms::selectForMonth($month);
		$fields[] = Forms::selectForYear($year);

		//Field city
		$cities = City::forSelectField();
		$fields[] = Forms::field([
			'id' => 'city_id',
			'type' => 'select',
			'label' => trans('app.city'),
			'data' => $cities,
			'selected' => $account['city_id'],
			'required' => false,
		]);

		//Field Gender
		$genders = Gender::forSelectField();
		$fields[] = Forms::field([
			'id' => 'gender',
			'type' => 'radio',
			'label' => trans('app.gender'),
			'data' => $genders,
			'selected' => $account['gender'],
			'required' => false,
		]);

		//Field uid
		$fields[] = Forms::field([
			'id' => 'uid',
			'type' => 'hidden',
			'value' => $id,
		]);

    /* -- AVATAR -- */
    $imgField = Forms::field([
      'id' => 'img',
      'type' => 'file',
      'label' => trans('app.img'),
      'description' => trans('app.imgFieldDesc'),
    ]);

    if($account['avatar'])
    {
      $imgThumb = $this->avatar->getThumb($this->dirName,$account['avatar']);
      $imgDeleteLink = renderLink('#',['id' => 'delete-img','text' => trans('app.delete')]);

      $fields[] = Forms::field([
        'id' => 'imgthumb',
        'type' => 'description',
        'value' => $imgThumb.' '.$imgDeleteLink,
      ]);

      //Img field
      $fields[] = $imgField;
    }
    else
    {
      $fields[] = $imgField;
    }

		$fields[] = Forms::buttonSave();
		$fields[] = Forms::buttonCancel();

		return Forms::get([
			'id' => 'edit-account',
			'enctype' => 'file',
			'action' => route('accountUpdate'),
			'fields' => $fields,
		]);
	}

	public function firsFormUpdate($request)
	{
		$account = UserAccounts::firstOrNew(['uid' => $request->uid]);
		$account->name = $request->name;
		$account->first_name = $request->first_name;
		$account->phone = $request->phone;
		$account->save();
	}

	public function secondFormUpdate($request)
	{
		if($request->number)
		{
			$input_date = $request->number.'.'.$request->month.'.'.$request->year.'.';
			$dt = Carbon::parse($input_date);
			$dateTimestamp = $dt->timestamp;
		}
		else
			$dateTimestamp = null;

		$account = UserAccounts::find($request->uid);
		$account->date = $dateTimestamp;
		$account->city_id = $request->city_id;
		$account->gender = $request->gender;
    //save img
    $account->avatar = $request->file('img') ? $this->setAvatar($request) : '';

		$account->save();

	}

	public function getForm($uid,$status)
	{
		if($status == config('user.status.one'))
			return $this->firstEditForm($uid);
		elseif($status == config('user.status.two'))
			return $this->secondEditForm($uid);
	}

  private function setAvatar($request, $imgField = null)
  {
    if($request->file('img'))
    {
      $dt = Carbon::parse(Auth::user()->created_at);
      $dateTimestamp = $dt->timestamp;

      $this->avatar->input($request->file('img'))
        ->fileName($dateTimestamp)
        ->move($this->dirName)
        ->resize($this->w_img, $this->h_img, false);

      return $this->avatar->getFileName();
    }
    else
    {
      if(!$request->file('img') && !empty($imgField))
        $this->avatar->delete($this->dirName,$imgField);

      return '';
    }
  }




}