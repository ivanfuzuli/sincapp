<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSincappPostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sincapp_posts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('photo_path')->nullable();
			$table->string('photo_ext')->nullable();
			$table->string('title');
			$table->text('body');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sincapp_posts');
	}

}
