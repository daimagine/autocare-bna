<?php

class Update_Batch_Settlement {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('batch', function($table) {
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
            $table->decimal('clerk_amount_cash', 14, 2)->default(0);
            $table->decimal('clerk_amount_non_cash', 14, 2)->default(0);
            $table->string('state', 1)->default('U');
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
		Schema::table('batch', function($table) {
           $table->drop_column(
               array(
                   'fraction_50', 'fraction_100', 'fraction_200', 'fraction_500', 'fraction_1000', 'fraction_2000',
                   'fraction_5000', 'fraction_10000', 'fraction_20000', 'fraction_50000', 'fraction_100000',
                   'clerk_amount_cash', 'clerk_amount_non_cash', 'state', 'notes', 'created_at', 'updated_at'
               )
           );
        });
	}

}