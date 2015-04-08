<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExceptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('exceptions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('order_id');
			$table->string('library');
			$table->string('method');
			$table->string('exception');
			$table->boolean('status');
			$table->datetime('created_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('exceptions');

	}

}
