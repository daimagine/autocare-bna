<?php

class Access_Add_Timestamp {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		// add timestamp into access table
        Schema::table('access', function($table) {
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
		Schema::table('access', function($table) {
           $table->drop_column(array('created_at', 'updated_at'));
        });
	}

}