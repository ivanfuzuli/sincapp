<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('site_id')->index();
			$table->integer('post_id')->index();
			$table->string('author');
			$table->string('author_email');
			$table->string('author_url');
			$table->string('author_ip');
			$table->datetime('post_date');
			$table->datetime('post_date_gmt');
			$table->text('content');
			$table->boolean('approved');
			$table->integer('comment_parent');
			$table->integer('user_id')->index()->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('comments');
	}

}
