<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExistingColumnToDomainOrders extends Migration {

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
			$table->boolean('external_registerer')->after('package');
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
			$table->dropColumn('external_registerer');
		});
	}

}
