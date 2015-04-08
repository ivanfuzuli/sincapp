<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('slug')->index();
			$table->integer('site_id')->index();
			$table->integer('blog_id')->index();
			$table->integer('author')->index();
			$table->datetime('post_date');
			$table->datetime('post_date_gmt');
			$table->string('title');
			$table->text('content');
			$table->string('status')->index();
			$table->string('comment_status');
			$table->datetime('modified');
			$table->datetime('modified_gmt');
			$table->integer('comment_count');
			$table->boolean('ping_status');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('posts');
	}

}
