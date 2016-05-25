<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model {

	public $timestamps = false;

	public static function forSelectField()
	{
		$cities = self::select('id','value')
			->orderBy('id')
			->get()
			->toArray();

		foreach($cities as $key=> $value)
		{
			$data[$value['id']] = $value['value'];
		}

		return $data;
	}

}
