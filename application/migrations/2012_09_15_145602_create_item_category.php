<?php

class Create_Item_Category {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('item_category', function($table){
            $table->increments('id')->attributes(null);
            $table->string('name', 80);
            $table->string('description', 255)->nullable();
            $table->boolean('status')->default(true);
            $table->string('picture', 100);
        });

        Schema::create('item_type', function($table){
            $table->increments('id')->attributes(null);
            $table->integer('item_category_id');
            $table->string('name', 80);
            $table->string('description', 255)->nullable();
            $table->boolean('status')->default(true);
            $table->foreign('item_category_id')
            ->references('id')
                ->on('item_category')
                ->on_update('restrict')
                ->on_delete('restrict');
        });

        Schema::create('item', function($table){
            $table->increments('id')->attributes(null);
            $table->integer('item_type_id');
            $table->index('item_type_id');
            $table->integer('item_category_id');
            $table->index('item_category_id');
            $table->integer('unit_id');
            $table->string('name', 150);
            $table->string('code', 10)->nullable();
            $table->integer('stock')->default(0);
            $table->string('description', 255)->nullable();
            $table->decimal('price', 14, 2)->default(0.00);
            $table->string('vendor', 120)->nullable();
            $table->boolean('status')->default(true);
            $table->timestamp('expiry_date')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('update_at')->nullable();
            $table->foreign('item_category_id')
                ->references('id')
                ->on('item_category')
                ->on_update('restrict')
                ->on_delete('restrict');
            $table->foreign('item_type_id')
                ->references('id')
                ->on('item_type')
                ->on_update('restrict')
                ->on_delete('restrict');
            $table->foreign('unit_id')
                ->references('id')
                ->on('unit_type')
                ->on_update('restrict')
                ->on_delete('restrict');
        });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('item_type');
        Schema::drop('item_category');
        Schema::drop('category');
    }

}