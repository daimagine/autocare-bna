<?php

class Update_Membership_Customer {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('membership', function($table){
			$table->integer('customer_id');
		});
		Schema::table('customer', function($table){
			$table->drop_column(array('register_date', 'membership_id'));
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('membership', function($table){
			$table->drop_column(array('customer_id'));
		});
		Schema::table('customer', function($table){
			$table->date('register_date');
			$table->integer('membership_id');
		});
	}

}