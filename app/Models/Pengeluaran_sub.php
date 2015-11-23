<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran_sub extends Model {

	protected 	$table		= 'pengeluaran_sub_laravel';
	protected 	$primaryKey	= 'pengels_id';
	protected 	$fillable	= ['pengel_id', 'mat_id', 'pengels_permintaan', 'pengels_realisasi', 'pengels_ket'];
	public 		$timestamps	= false;

	public static function fetch($pengel_id){
		$i = new static;
		return self::select('B.mat_nama', 'B.mat_spesifikasi', 'C.wrn_nama', 'D.mats_nama', $i->table.'.pengels_permintaan', $i->table.'.pengels_realisasi', $i->table.'.pengels_ket')
				->join('material_laravel AS B', $i->table.'.mat_id', '=', 'B.mat_id')
				->join('warna AS C', 'B.wrn_id', '=', 'C.wrn_id')
				->join('material_satuan AS D', 'B.matsr_id', '=', 'D.mats_id')
				->where($i->table.'.pengel_id', $pengel_id)
				->get();
	}
	public static function getQuantity($matId, $date){
		$i = new static;
		return self::select($i->table.'.pengels_realisasi', 'C.mat_perbandingan')
				->join('pengeluaran_laravel AS B', $i->table.'.pengel_id', '=', 'B.pengel_id')
				->join('material_laravel AS C', $i->table.'.mat_id', '=', 'C.mat_id')
				->where('B.pengel_date', $date)
				->where($i->table.'.mat_id', $matId)
				->get();
	}

}