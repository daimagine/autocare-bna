<?php

class Create_Item_Stock_Flow_Table {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account_transactions', function($table){
            $table->string('approved_status', 0);
        });


        Schema::create('item_stock_flow', function($table){
            $table->increments('id');
            $table->integer('item_id');
            $table->index('item_id');
            $table->integer('account_transaction_id');
            $table->index('account_transaction_id');
            $table->string('quantity', 80);
            $table->string('type', 1)->nullable();
            $table->timestamp('date');
            $table->string('status', 1);
            $table->integer('configured_by');
            $table->index('configured_by');
            $table->foreign('item_id')
                ->references('id')
                ->on('item')
                ->on_update('restrict')
                ->on_delete('restrict');
            $table->foreign('account_transaction_id')
                ->references('id')
                ->on('account_transaction')
                ->on_update('restrict')
                ->on_delete('restrict');
        });

        Schema::create('item_price', function($table) {
            $table->increments('id');
            $table->integer('item_id');
            $table->index('item_id');
            $table->decimal('price', 14, 2)->default(0.00);
            $table->string('status', 1);
            $table->timestamp('date');
            $table->timestamp('expiry_date');
            $table->integer('configured_by');
            $table->index('configured_by');
            $table->foreign('item_id')
                ->references('id')
                ->on('item')
                ->on_update('restrict')
                ->on_delete('restrict');
            $table->foreign('configured_by')
                ->references('id')
                ->on('user')
                ->on_update('restrict')
                ->on_delete('restrict');
        });

        Schema::table('sub_account_trx', function($table) {
            $table->string('approved_status', 1);
            $table->date('created_at');
            $table->date('updated_at');
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
        Schema::drop('item_price');
        Schema::table('account_transactions', function($table) {
            $table->drop_column(array('approved_status'));
        });

    }

}