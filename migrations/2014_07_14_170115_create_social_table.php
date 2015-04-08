<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('social', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('site_id');
			$table->string('facebook');
			$table->string('twitter');
			$table->string('google');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('social');
	}

}
