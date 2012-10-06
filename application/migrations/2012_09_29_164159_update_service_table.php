<?php

class Update_Service_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('service', function($table) {
            $table->string('status', 1)->default(1);
        });

        Schema::table('service_formula', function($table) {
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('service', function($table) {
            $table->drop_column('status');
        });

        Schema::table('service_formula', function($table) {
            $table->drop_column(array('created_at', 'updated_at'));
        });
	}

}