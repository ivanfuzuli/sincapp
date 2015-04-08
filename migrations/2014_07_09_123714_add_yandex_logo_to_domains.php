<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddYandexLogoToDomains extends Migration {

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
				$table->boolean('yandex_logo_status')->after('years');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('domains', function(Blueprint $table)
		{
			//
			$table->dropColumn('yandex_logo_status');
		});
	}

}
