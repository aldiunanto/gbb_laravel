<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retur_penerimaan_sub extends Model {

	protected	$table		= 'retur_penerimaan_sub_laravel';
	protected	$primaryKey	= 'returpeners_id';
	protected	$fillable	= ['returpener_id', 'peners_id', 'returpeners_jml', 'returpeners_reason', 'returpeners_is_reduced'];
	public 		$timestamps	= false;

	public static function fetch($returpener_id){
		$i = new static;
		return self::select('E.mat_nama', 'E.mat_spesifikasi', 'F.wrn_nama', 'G.mats_nama', 'B.peners_jml', $i->table.'.returpeners_jml', $i->table.'.returpeners_reason')
					->join('penerimaan_sub_laravel AS B', $i->table.'.peners_id', '=', 'B.peners_id')
					->join('po_sub_laravel AS C', 'B.pos_id', '=', 'C.pos_id')
					->join('permintaan_barang_sub AS D', 'C.pbs_id', '=', 'D.pbs_id')
					->join('material_laravel AS E', 'D.mat_id', '=', 'E.mat_id')
					->leftJoin('warna AS F', 'E.wrn_id', '=', 'F.wrn_id')
					->join('material_satuan AS G', 'E.matsp_id', '=', 'G.mats_id')
					->where($i->table.'.returpener_id', $returpener_id)
					->get();
	}

}