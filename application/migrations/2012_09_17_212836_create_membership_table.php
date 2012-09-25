<?php

class Create_Membership_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('membership', function($table){
            $table->increments('id');
            $table->string('number', 50);
            $table->boolean('status')->default(true);
            $table->integer('discount_id');
            $table->date('registration_date');
            $table->date('expiry_date');
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
        Schema::drop('membership');
	}

}