<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogPicsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blog_pics', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('site_id')->index();
			$table->integer('blog_id')->index();
			$table->integer('pic_id');
			$table->integer('sub_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('blog_pics');
	}

}
