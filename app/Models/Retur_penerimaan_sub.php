<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retur_penerimaan_sub extends Model {

	protected	$table		= 'retur_penerimaan_sub_laravel';
	protected	$primaryKey	= 'returpeners_id';
	protected	$fillable	= ['returpener_id', 'peners_id', 'returpeners_jml', 'returpeners_reason', 'returpeners_is_reduced'];
	public 		$timestamps	= false;

	public static function fetch($returpener_id, $pener_id = null){
		$i 		= new static;
		$get 	= self::select('E.mat_id', 'E.mat_nama', 'E.mat_spesifikasi', 'F.wrn_nama', 'G.mats_nama', 'B.peners_jml', $i->table.'.returpeners_jml', $i->table.'.returpeners_reason', $i->table.'.'.$i->primaryKey, 'H.returpener_status')
					->join('penerimaan_sub_laravel AS B', $i->table.'.peners_id', '=', 'B.peners_id')
					->join('po_sub_laravel AS C', 'B.pos_id', '=', 'C.pos_id')
					->join('permintaan_barang_sub AS D', 'C.pbs_id', '=', 'D.pbs_id')
					->join('material_laravel AS E', 'D.mat_id', '=', 'E.mat_id')
					->leftJoin('warna AS F', 'E.wrn_id', '=', 'F.wrn_id')
					->join('material_satuan AS G', 'E.matsp_id', '=', 'G.mats_id')
					->join('retur_penerimaan_laravel AS H', $i->table.'.returpener_id', '=', 'H.returpener_id');

		if(! is_null($returpener_id)) $get->where($i->table.'.returpener_id', $returpener_id);
		if(! is_null($pener_id)) $get->where('H.pener_id', $pener_id);

		return $get->get();
	}
	public static function getMatData($returpener_id){
		$i = new static;
		return self::select($i->table.'.'.$i->primaryKey, $i->table.'.returpeners_is_reduced', $i->table.'.returpeners_jml', 'E.mat_id', 'E.mat_stock_akhir')
					->join('penerimaan_sub_laravel AS B', $i->table.'.peners_id', '=', 'B.peners_id')
					->join('po_sub_laravel AS C', 'B.pos_id', '=', 'C.pos_id')
					->join('permintaan_barang_sub AS D', 'C.pbs_id', '=', 'D.pbs_id')
					->join('material_laravel AS E', 'D.mat_id', '=', 'E.mat_id')
					->where($i->table.'.returpener_id', $returpener_id)
					->get();
	}
	public static function getQuantity($matId, $date){
		$i = new static;
		return self::select($i->table.'.returpeners_jml')
					->join('retur_penerimaan_laravel AS B', $i->table.'.returpener_id', '=', 'B.returpener_id')
					->join('penerimaan_sub_laravel AS C', $i->table.'.peners_id', '=', 'C.peners_id')
					->join('po_sub_laravel AS D', 'C.pos_id', '=', 'D.pos_id')
					->join('permintaan_barang_sub AS E', 'D.pbs_id', '=', 'E.pbs_id')
					->join('material_laravel AS F', 'E.mat_id', '=', 'F.mat_id')
					->whereDate('B.created_at', '=', $date)
					->where('E.mat_id', $matId)
					->get();
	}

}