<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAmountColumnToPaymentSuccessesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('payment_successes', function(Blueprint $table)
		{
			//
			$table->integer('amount')->after('order_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('payment_successes', function(Blueprint $table)
		{
			//
			$table->dropColumn('amount');
		});
	}

}
