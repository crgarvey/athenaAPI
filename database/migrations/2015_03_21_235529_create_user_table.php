<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user', function(Blueprint $table)
        {
            $table->primary('id');
            $table->char('id', 36)->unique();
            $table->string('key', 36);
            $table->enum('encoding', ['json', 'http'])->default('json');
            $table->timestamp('latestauth_at')->nullable()->default(null);
            $table->index('key');
            $table->index('encoding');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user');
	}

}
