<?php

class Update_Account_Add_Category {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table(Account::$table, function($table) {
            $table->string('category', 1)->default(AccountCategory::ACCOUNTING);
        });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table(Account::$table, function($table) {
            $table->drop_column(array( 'category' ));
        });
	}

}