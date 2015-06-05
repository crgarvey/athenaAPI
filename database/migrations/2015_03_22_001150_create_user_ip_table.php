<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserIpTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('user_ip', function(Blueprint $table)
        {
            $table->integer('id', true, false)->unique();
            $table->char('user_id', 36);
            $table->string('ip', 15);
            $table->index('user_id');
            $table->index('ip');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_ip');
	}

}
