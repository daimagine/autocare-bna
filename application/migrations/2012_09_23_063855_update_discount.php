<?php

class Update_Discount {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('discount', function($table) {
			$table->decimal('registration_fee', 14, 2)->default(0);
			$table->integer('duration')->default(0);
			$table->string('duration_period', 1)->default('M');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('discount', function($table) {
			$table->drop_column(array('registration_fee','duration','duration_period'));
		});
	}

}