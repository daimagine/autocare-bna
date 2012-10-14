<?php

class Update_Account_Transaction {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::drop('accounts');
        Schema::table('sub_account_trx', function($table) {
            $table->drop_column(array( 'qty', 'desc' ));
            $table->integer('quantity')->default(0);
            $table->decimal('discount', 14, 2)->default(0.00);
            $table->decimal('tax', 14, 2)->default(0.00);
            $table->boolean('status')->default(true);
        });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::create('accounts', function($table) {
            $table->integer('id', 11);
        });
        Schema::table('sub_account_trx', function($table) {
            $table->drop_column(array( 'quantity', 'discount', 'tax', 'status' ));
            $table->integer('qty');
            $table->string('desc');
        });
	}

}