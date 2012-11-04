<?php

class Update_Account_Transaction_Add_Category {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table(AccountTransaction::$table, function($table) {
            $table->integer('account_id');
        });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table(AccountTransaction::$table, function($table) {
            $table->drop_column(array( 'account_id' ));
        });
	}

}