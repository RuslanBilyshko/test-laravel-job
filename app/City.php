<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model {

	public $timestamps = false;

	public static function forSelectField()
	{
		$cities = self::select('id','title')
			->orderBy('id')
			->get()
			->toArray();

		foreach($cities as $key=> $value)
		{
			$data[$value['id']] = $value['title'];
		}

		return $data;
	}

}
