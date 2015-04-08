<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuPagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menu_pages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('site_id')->index();
			$table->integer('menu_id')->index();
			$table->integer('page_id');
			$table->integer('sort');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('menu_pages');
	}

}
