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
            $table->increments('id');
            $table->decimal('fraction_50', 14, 2)->default(0);
            $table->decimal('fraction_100', 14, 2)->default(0);
            $table->decimal('fraction_200', 14, 2)->default(0);
            $table->decimal('fraction_500', 14, 2)->default(0);
            $table->decimal('fraction_1000', 14, 2)->default(0);
            $table->decimal('fraction_2000', 14, 2)->default(0);
            $table->decimal('fraction_5000', 14, 2)->default(0);
            $table->decimal('fraction_10000', 14, 2)->default(0);
            $table->decimal('fraction_20000', 14, 2)->default(0);
            $table->decimal('fraction_50000', 14, 2)->default(0);
            $table->decimal('fraction_100000', 14, 2)->default(0);
            $table->decimal('amount', 14, 2)->default(0);
            $table->decimal('amount_cash', 14, 2)->default(0);
            $table->decimal('amount_non_cash', 14, 2)->default(0);
            $table->integer('user_id');
            $table->string('state', 1)->default('U');
            $table->date('settlement_date')->default('0000-00-00');
            $table->boolean('match')->default(false);
            $table->integer('success_transaction')->default(0);
            $table->boolean('status')->default(true);
            $table->text('notes')->nullable();
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