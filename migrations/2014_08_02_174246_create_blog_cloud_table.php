<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogCloudTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blog_cloud', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('site_id')->index();
			$table->integer('page_id')->index();
			$table->integer('blog_id')->index();
			$table->string('layout');		
			$table->integer('limit_count');
			$table->boolean('pagination');
			$table->boolean('view_here');	
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('blog_cloud');
	}

}
