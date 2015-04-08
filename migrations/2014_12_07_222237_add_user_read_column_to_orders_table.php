<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserReadColumnToOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('domain_orders', function(Blueprint $table)
		{
			//
			$table->boolean('user_read')->after('external_registerer');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('domain_orders', function(Blueprint $table)
		{
			//
			$table->dropColumn('user_read');
		});
	}

}
