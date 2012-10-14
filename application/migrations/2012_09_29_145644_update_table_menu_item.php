<?php

class Update_Table_Menu_Item {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{

        Schema::table('item_price', function($table) {
            $table->decimal('purchase_price', 14, 2)->default(0.00);
        });

        Schema::table('item', function($table) {
            $table->decimal('purchase_price', 14, 2)->default(0.00);
        });

        Schema::table('sub_account_trx', function($table) {
            $table->text('remarks');
        });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('item_price', function($table) {
            $table->drop_column(array('purchase_price'));
        });

        Schema::table('item', function($table) {
            $table->drop_column(array('purchase_price'));
        });

        Schema::table('sub_account_trx', function($table) {
            $table->drop_column(array('remarks'));
        });
	}

}