<?php

class Blog_Install {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create posts table
		Schema::create('posts', function($table) {
			$table->increments('id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('category_id')->unsigned()->default(1);
			$table->string('title')->unique();
			$table->string('short_title')->nullable();
			$table->string('slug')->unique();
			$table->text('content')->nullable();
			$table->string('main_photo');
			$table->string('small_photo');
			$table->integer('number_views')->unsigned()->default(0);
			$table->integer('is_published')->unsigned()->default(1);
			$table->timestamp('viewed_at');
			$table->timestamp('event_date')->nullable();			
			$table->date('created_at')->nullable()->default('0000-00-00 00:00:00');
			$table->date('updated_at')->nullable()->default('0000-00-00 00:00:00');
		});

		// Create tags table
		Schema::create('tags', function($table) {
			$table->increments('id')->unsigned();
			$table->string('title')->unique();
			$table->string('slug')->unique();
			$table->date('created_at')->nullable()->default('0000-00-00 00:00:00');
			$table->date('updated_at')->nullable()->default('0000-00-00 00:00:00');
		});

		// Create categories table
		Schema::create('categories', function($table) {
			$table->increments('id')->unsigned();
			$table->string('title')->unique();
			$table->string('slug')->unique();
			$table->integer('visible')->unsigned()->default(1);
			$table->date('created_at')->nullable()->default('0000-00-00 00:00:00');
			$table->date('updated_at')->nullable()->default('0000-00-00 00:00:00');
		});

		// Create post_tag table
		Schema::create('post_tag', function($table) {
			$table->increments('id')->unsigned();
			$table->integer('post_id')->unsigned();
			$table->integer('tag_id')->unsigned();
			$table->date('created_at')->nullable()->default('0000-00-00 00:00:00');
			$table->date('updated_at')->nullable()->default('0000-00-00 00:00:00');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		// Drop all tables
		Schema::drop('posts');

		Schema::drop('tags');

		Schema::drop('categories');

		Schema::drop('post_tag');
	}
}