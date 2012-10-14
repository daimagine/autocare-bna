<?php

class Update_Membership_To_Vehicle {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('membership', function($table) {
            $table->integer('vehicle_id');
        });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('membership', function($table) {
            $table->drop_column(array( 'vehicle_id' ));
        });
	}

}