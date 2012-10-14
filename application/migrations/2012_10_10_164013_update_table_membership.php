<?php

class Update_Table_Membership {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('membership', function($table) {
            $table->string('vehicle_id', 11);
        });

        Schema::table('transaction', function($table) {
            $table->decimal('paid_amount', 14, 2)->default(0);
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
            $table->drop_column('vehicle_id');
        });
        Schema::table('transaction', function($table) {
            $table->drop_column('paid_amount');
        });
	}

}