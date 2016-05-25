<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_accounts', function(Blueprint $table)
		{
			$table->integer('uid');
			$table->string('name', 100);
			$table->string('first_name', 100);
			$table->string('phone', 50);
			$table->integer('date');
			$table->tinyInteger('gender');
			$table->integer('city_id');
			$table->string('avatar', 255);
			$table->primary('uid');
			$table->unique('uid');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_accounts');
	}

}
