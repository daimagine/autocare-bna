<?php

class Create_Clerk_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('settlement', function($table) {
            $table->decimal('fraction_50', 14, 2);
            $table->decimal('fraction_100', 14, 2);
            $table->decimal('fraction_200', 14, 2);
            $table->decimal('fraction_500', 14, 2);
            $table->decimal('fraction_1000', 14, 2);
            $table->decimal('fraction_2000', 14, 2);
            $table->decimal('fraction_5000', 14, 2);
            $table->decimal('fraction_10000', 14, 2);
            $table->decimal('fraction_20000', 14, 2);
            $table->decimal('fraction_50000', 14, 2);
            $table->decimal('fraction_100000', 14, 2);
            $table->integer('create_by');
            $table->timestamps();
        });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('settlement');
	}

}