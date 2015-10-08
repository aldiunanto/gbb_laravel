<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengeluaranTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pengeluaran_laravel', function(Blueprint $table)
		{
			$table->increments('pengel_id');
			$table->integer('deptbg_id');
			$table->string('pengel_bpb', 50);
			$table->string('pengel_po', 50);
			$table->date('pengel_date');
			$table->tinyInteger('visibility');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pengeluaran_laravel');
	}

}
