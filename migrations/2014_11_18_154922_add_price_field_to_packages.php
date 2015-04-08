<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPriceFieldToPackages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('packages', function(Blueprint $table)
		{
			//
			$table->integer('price')->after('storage');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('pages', function(Blueprint $table)
		{
			//
			$table->dropColumn('price');
		});
	}

}
