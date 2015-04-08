<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentSucessesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payment_successes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('order_id');
			$table->string('auth_code');
			$table->string('reference');
			$table->string('ip');
			$table->boolean('read');
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
		Schema::drop('payment_successes');

	}

}
