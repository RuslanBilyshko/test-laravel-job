<?php

use App\Gender;
use Illuminate\Support\Facades\DB;

class GenderSeeder extends DatabaseSeeder
{
	public function run()
	{
		DB::table('genders')->delete();
		Gender::create([
			'id' => 1,
			'value' => 'male',
		]);

		Gender::create([
			'id' => 2,
			'value' => 'female',
		]);


	}
}