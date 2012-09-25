<?php

class Access_Update {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('access', function($table){
            $table->increments('id');
            $table->string('name', 80);
            $table->string('description', 255)->nullable();
            $table->string('action', 255)->nullable()->unique();
            $table->boolean('status')->default(true);
            $table->boolean('parent')->default(false);
            $table->boolean('visible')->default(false);
            $table->string('type', 1)->default('L'); // M : Main nav, S : sub nav, L : link
            $table->integer('parent_id')->nullable();
            $table->string('image',200)->nullable();
            $table->timestamps();
        });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('access');
	}

}