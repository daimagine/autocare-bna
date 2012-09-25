<?php

class Create_Discount_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('discount', function($table){
            $table->increments('id');
            $table->string('code', 50);
            $table->string('description', 255)->nullable();
            $table->boolean('status')->default(true);
            $table->float('value')->default(0);
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
        Schema::drop('discount');
	}

}