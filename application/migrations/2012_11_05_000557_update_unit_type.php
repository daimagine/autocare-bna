<?php

class Update_Unit_Type {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table(UnitType::$table, function($table) {
            $table->integer('item_category_id');
        });
		//item_category_id
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table(UnitType::$table, function($table) {
            $table->drop_column(array( 'item_category_id' ));
        });
	}

}