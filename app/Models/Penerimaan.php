<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Penerimaan extends Model {

	protected	$table		= 'penerimaan_laravel';
	protected	$primaryKey	= 'pener_id';
	protected	$fillable	= ['po_id', 'pener_date', 'userid_input', 'visibility'];
	public 		$timestamps	= true;

	public static function fetchData(){
		$i = new static;
		$get = self::select($i->table.'.'.$i->primaryKey, 'B.po_id', 'B.po_no', 'B.po_tgl_kedatangan', 'D.sup_nama', DB::raw('MAX('.$i->table.'.pener_date) AS pener_date'))
					->join('po_laravel AS B', $i->table.'.po_id', '=', 'B.po_id')
					->join('permintaan_barang AS C', 'B.pb_id', '=', 'C.pb_id')
					->join('supplier_laravel AS D', 'C.sup_id', '=', 'D.sup_id')
					->where($i->table.'.visibility', 1)
					->groupBy($i->table.'.po_id');

		return $get->orderBy($i->table.'.pener_date', 'DESC')->get();
	}
	public static function fetchAll($po_id){
		return self::select('pener_id', 'pener_date')
					->where('po_id', $po_id)
					->where('visibility', 1)
					->orderBy('pener_date', 'ASC')
					->get();
	}

}