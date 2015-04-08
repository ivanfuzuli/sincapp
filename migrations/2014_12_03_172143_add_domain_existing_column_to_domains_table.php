<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDomainExistingColumnToDomainsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('domains', function(Blueprint $table)
		{
			//
			$table->boolean('external_registerer')->after('site_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('payment_successess', function(Blueprint $table)
		{
			//
			$table->dropColumn('external_registerer');
		});
	}

}
