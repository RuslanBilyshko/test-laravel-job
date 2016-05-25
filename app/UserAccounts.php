<?php namespace App;

use App\Http\Controllers\Avatar;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserAccounts extends Model {

	public $timestamps = false;
	public $primaryKey = 'uid';
	public $fillable = ['uid','name','first_name','phone','date','gender','city_id','avatar'];

	public static function findAccount($uid)
	{
		$query = self::find($uid);

		if($query)
		{
			if($query->avatar)
			{
				$data['avatar'] = $query->avatar;
			}

			$data['name'] = $query->name;
			$data['first_name'] = $query->first_name;
			$data['phone'] = $query->phone;

			if($query->date)
			{
				$timestamp = $query->date;
				$dt = Carbon::createFromTimestamp($timestamp);
				$day = $dt->day;
				$month = $dt->month - 2;
				$year = $dt->year;
				$date = $day.' '.trans('months.'.$month).' '.$year;
				$data['date'] = $date;
			}

			if($query->gender)
			{
				$g = Gender::find($query->gender,['value']);
				$data['gender'] = trans('app.'.$g->value);
			}

			if($query->city_id)
			{
				$g = City::find($query->city_id,['title']);
				$data['city'] = $g->title;
			}

			return $data;
		}
		else
			return null;
	}

}
