<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentErrorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payment_errors', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('order_id');
			$table->string('response_code');
			$table->string('response_text');
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
		Schema::drop('payment_errors');

	}

}
