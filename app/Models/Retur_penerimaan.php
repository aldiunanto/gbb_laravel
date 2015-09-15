<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retur_penerimaan extends Model {

	protected	$table		= 'retur_penerimaan_laravel';
	protected	$primaryKey	= 'returpener_id';
	protected	$fillable	= ['userid_input', 'pener_id', 'returpener_status', 'returpener_vd_desc', 'visibility', 'created_at'];
	public 		$timestamps = false;

	public static function fetchApprovement($role){
		$i 		= new static;
		$get 	= self::select($i->table.'.'.$i->primaryKey, $i->table.'.returpener_status', 'C.po_no', 'E.sup_nama', 'B.pener_date', $i->table.'.created_at')
					->join('penerimaan_laravel AS B', $i->table.'.pener_id', '=', 'B.pener_id')
					->join('po_laravel AS C', 'B.po_id', '=', 'C.po_id')
					->join('permintaan_barang AS D', 'C.pb_id', '=', 'D.pb_id')
					->join('supplier_laravel AS E', 'D.sup_id', '=', 'E.sup_id')
					->where($i->table.'.visibility', 1);

		switch($role){
			case 1 : $get->where($i->table.'.returpener_status', '<>', 6); break;
			case 2 : $get->where($i->table.'.returpener_status', 5); break;
			case 4 : $get->where($i->table.'.returpener_status', 3); break;
			case 5 : $get->where($i->table.'.returpener_status', 4); break;
			case 6 : $get->where($i->table.'.returpener_status', 2); break;
			case 7 : $get->where($i->table.'.returpener_status', 1); break;
		}

		return $get->orderBy($i->table.'.created_at', 'DESC')->get();
	}
	public static function fetchHead($returpener_id){
		$i = new static;
		return self::select($i->table.'.created_at', 'C.po_no', 'E.sup_nama', 'E.sup_alamat', 'E.sup_cp', 'E.sup_telepon', 'B.pener_date')
					->join('penerimaan_laravel AS B', $i->table.'.pener_id', '=', 'B.pener_id')
					->join('po_laravel AS C', 'B.po_id', '=', 'C.po_id')
					->join('permintaan_barang AS D', 'C.pb_id', '=', 'D.pb_id')
					->join('supplier_laravel AS E', 'D.sup_id', '=', 'E.sup_id')
					->where($i->table.'.'.$i->primaryKey, $returpener_id)
					->first();
	}

}