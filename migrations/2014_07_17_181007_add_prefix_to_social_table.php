<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrefixToSocialTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('social', function(Blueprint $table)
		{
			//
			$table->string('prefix')->after('site_id')->index()->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('social', function(Blueprint $table)
		{
			//
			$table->dropColumn('prefix');
		});
	}

}
