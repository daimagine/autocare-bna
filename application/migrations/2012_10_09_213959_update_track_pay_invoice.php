<?php

class Update_Track_Pay_Invoice {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('account_transactions', function($table) {
        });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('account_transactions', function($table) {
        });
	}

}