<?php

class Update_Customer {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('customer', function($table) {
            $table->drop_column('update_date');
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
		Schema::table('customer', function($table) {
            $table->drop_column(array('created_at', 'updated_at', 'status'));
            $table->date('update_date');
        });
	}

}