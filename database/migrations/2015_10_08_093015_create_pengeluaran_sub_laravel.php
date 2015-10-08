<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengeluaranSubLaravel extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pengeluaran_sub_laravel', function(Blueprint $table)
		{
			$table->increments('pengels_id');
			$table->integer('pengel_id');
			$table->integer('mat_id');
			$table->double('pengels_permintaan');
			$table->double('pengels_realisasi');
			$table->string('pengels_ket', 120);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pengeluaran_sub_laravel');
	}

}
