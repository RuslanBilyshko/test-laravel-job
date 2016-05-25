<?php

use App\City;
use Illuminate\Support\Facades\DB;

class CitySeeder extends DatabaseSeeder
{
	public function run()
	{
		DB::table('cities')->delete();
		City::create([
			'id' => 1,
			'title' => 'Полтава',
		]);

		City::create([
			'id' => 2,
			'title' => 'Кременчуг',
		]);

		City::create([
			'id' => 3,
			'title' => 'Харьков',
		]);

	}
}