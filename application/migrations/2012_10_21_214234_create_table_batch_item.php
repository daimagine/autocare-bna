<?php

class Create_Table_Batch_Item {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('batch_item', function($table) {
            $table->increments('id');
            $table->integer('batch_id');
            $table->index('batch_id');
            $table->integer('item_id');
            $table->index('item_id');
            $table->integer('sales_count')->default(0);
            $table->decimal('sales_amount', 14, 2)->default(0.00);
        });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('batch_item');
	}

}