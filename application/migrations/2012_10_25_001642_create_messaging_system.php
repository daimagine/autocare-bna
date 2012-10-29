<?php

class Create_Messaging_System {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('conversation_user', function($table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('conversation_id');
            $table->boolean('deleted')->default(false);
            $table->boolean('read')->default(false);
            $table->timestamps();
        });

        Schema::create('conversation', function($table) {
            $table->increments('id');
            $table->string('subject');
            $table->timestamps();
        });

        Schema::create('message', function($table) {
            $table->increments('id');
            $table->integer('topic_id');
            $table->integer('user_id');
            $table->boolean('deleted')->default(false);
            $table->boolean('read')->default(false);
            $table->text('message');
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
		Schema::drop('conversation_user');
		Schema::drop('conversation');
		Schema::drop('message');
	}

}