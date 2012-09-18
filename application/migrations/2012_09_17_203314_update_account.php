<?php

class Update_Account {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('account', function($table){
            $table->increments('id');
            $table->string('name', 80);
            $table->string('description', 255)->nullable();
            $table->boolean('status')->default(true);
            $table->string('type', 1)->nullable(); // M : Main nav, S : sub nav, L : link
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
        Schema::drop('account');
	}

}