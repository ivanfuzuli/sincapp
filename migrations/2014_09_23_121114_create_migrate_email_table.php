<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMigrateEmailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('migrate_email', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('email');
			$table->string('name');
			$table->string('domain');
			$table->integer('site_id');
			$table->string('password');
			$table->datetime('mailed_date')->nullable();
			$table->boolean('mailed_status');
			$table->boolean('added_status');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('migrate_email');
	}

}
