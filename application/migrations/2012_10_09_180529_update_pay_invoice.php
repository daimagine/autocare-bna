<?php

class Update_Pay_Invoice {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('account_transactions', function($table) {
           $table->string('subject_payment', 255)->nullable();
        });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('account_transactions', function($table) {
            $table->drop_column( array('subject_payment') );
        });
	}

}