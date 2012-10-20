<?php

class Update_Vehicle {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table(Vehicle::$table, function($table) {
            $table->string('year',4)->nullable();
        });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table(Vehicle::$table, function($table) {
            $table->drop_column(array('year'));
        });
	}

}