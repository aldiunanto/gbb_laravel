<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran_sub extends Model {

	protected 	$table		= 'pengeluaran_sub_laravel';
	protected 	$primaryKey	= 'pengels_id';
	protected 	$fillable	= ['pengel_id', 'mat_id', 'pengels_permintaan', 'pengels_realisasi', 'pengels_ket'];
	public 		$timestamps	= false;

}