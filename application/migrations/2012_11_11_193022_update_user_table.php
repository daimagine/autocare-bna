<?php

class Update_User_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table(User::$table, function($table) {
            $table->string('picture', 100);
        });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table(User::$table, function($table) {
            $table->drop_column(array( 'picture' ));
        });
	}

}