<?php

class Update_Account_Transaction {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('account_transactions', function($table) {
            $table->drop_column('to_from');
            $table->string('subject', 255)->nullable();
            $table->date('invoice_date');
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
        Schema::table('account_transactions', function($table) {
            $table->drop_column(array('subject', 'invoice_date', 'created_at', 'updated_at'));
            $table->string('to_from', 255)->nullable();
        });
	}

}