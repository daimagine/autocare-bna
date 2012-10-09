<?php

class Craete_Table_Transaction_Item {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('transaction_item', function($table){
            $table->increments('id');
            $table->integer('item_id');
            $table->index('item_id');
            $table->integer('item_price_id');
            $table->index('item_price_id');
            $table->integer('transaction_id');
            $table->index('transaction_id');
            $table->integer('quantity');
            $table->string('description', 255)->nullable();
        });

	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('item_stock_flow');
	}

}