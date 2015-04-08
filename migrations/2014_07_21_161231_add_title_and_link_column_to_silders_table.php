<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTitleAndLinkColumnToSildersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sliders', function(Blueprint $table)
		{
			//
			$table->text('title');
			$table->string('link');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('sliders', function(Blueprint $table)
		{
			//
			$table->dropColumn('title');
			$table->dropColumn('link');
		});
	}

}
