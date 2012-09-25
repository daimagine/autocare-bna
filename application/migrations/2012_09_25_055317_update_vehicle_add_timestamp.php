<?php

class Update_Vehicle_Add_Timestamp {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('vehicle', function($table) {
			$table->boolean('status')->default(true);
            $table->date('created_at');
            $table->date('updated_at');
        });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('vehicle', function($table) {
            $table->drop_column(array('created_at', 'updated_at', 'status'));
        });
	}

}