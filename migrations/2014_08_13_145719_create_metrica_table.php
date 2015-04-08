<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetricaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('metrica', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('site_id')->unique();
			$table->string('site_url');
			$table->string('counter_id');
			$table->text('code');
			$table->tinyinteger('visor');
			$table->tinyinteger('click_map');
			$table->tinyinteger('external_links');
			$table->tinyinteger('denial');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('metrica');
	}

}
