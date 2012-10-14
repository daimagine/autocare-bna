<?php

class Create_News {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('news', function($table) {
            $table->string('title', 150);
            $table->string('resume', 255)->nullable();
            $table->string('file_path', 100)->nullable();
            $table->text('content')->nullable();
            $table->boolean('status')->default(true);
            $table->date('created_at');
            $table->date('updated_at');

            //index
            $table->increments('id');
        });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('news');
	}

}