<?php

class Update_Sub_Account_Trx {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sub_account_trx', function($table) {
            $table->decimal('tax_amount', 14, 2);
        });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('sub_account_trx', function($table) {
            $table->drop_column( array('tax_amount') );
        });
	}

}