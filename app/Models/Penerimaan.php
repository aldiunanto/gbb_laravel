<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Penerimaan extends Model {

	protected	$table		= 'penerimaan_laravel';
	protected	$primaryKey	= 'pener_id';
	protected	$fillable	= ['po_id', 'pener_date', 'userid_input', 'qa_check', 'visibility'];
	public 		$timestamps	= true;

	public static function fetchData($args){
		$i = new static;
		$get = self::select($i->table.'.'.$i->primaryKey, 'B.po_id', 'B.po_no', 'B.po_tgl_kedatangan', 'D.sup_nama', DB::raw('MAX('.$i->table.'.pener_date) AS pener_date'))
					->join('po_laravel AS B', $i->table.'.po_id', '=', 'B.po_id')
					->join('permintaan_barang AS C', 'B.pb_id', '=', 'C.pb_id')
					->join('supplier_laravel AS D', 'C.sup_id', '=', 'D.sup_id')
					->where($i->table.'.visibility', 1);

		if(! is_null($args['search']['s'])){
			switch($args['search']['field']){
				case 'po_no' 	: $prefix = 'B.'; break;
				case 'sup_nama'	: $prefix = 'D.'; break;
			}

			$get->where($prefix . $args['search']['field'], 'LIKE', '%' . $args['search']['s'] . '%');
		}

		$get->groupBy($i->table.'.po_id')->orderBy($i->table.'.created_at', 'DESC');
		return [
			'total'	=> $get->get()->count(),
			'fetch'	=> $get->limit($args['perPage'])->offset(($args['currPage'] - 1) * $args['perPage'])->get()
		];

		//return $get->groupBy($i->table.'.po_id')->orderBy($i->table.'.created_at', 'DESC')->paginate($args['perPage']);
	}
	public static function fetchAll($po_id){
		return self::select('pener_id', 'pener_date')
					->where('po_id', $po_id)
					->where('visibility', 1)
					->orderBy('pener_date', 'ASC')
					->get();
	}
	public static function fetchHead($pener_id){
		$i = new static;
		return self::select($i->table.'.pener_date', $i->table.'.created_at', 'B.po_no', 'D.sup_nama')
					->join('po_laravel AS B', $i->table.'.po_id', '=', 'B.po_id')
					->join('permintaan_barang AS C', 'B.pb_id', '=', 'C.pb_id')
					->join('supplier_laravel AS D', 'C.sup_id', '=', 'D.sup_id')
					->where($i->table.'.'.$i->primaryKey, $pener_id)->first();
	}
	public static function is_penerimaanReturan($pener_id){
		$i = new static;
		return self::select('C.userid_input')
					->join('retur_penerimaan_laravel AS B', $i->table.'.'.$i->primaryKey, '=', 'B.'.$i->primaryKey)
					->join('penerimaan_returan AS C', 'B.returpener_id', '=', 'C.returpener_id')
					->where($i->table.'.'.$i->primaryKey, $pener_id)
					->count();
	}
	public static function purchasemonthly($date, $type, $sortBy){
		$i 		= new static;
		$get	= self::select($i->table.'.'.$i->primaryKey, $i->table.'.pener_date', 'B.po_no', 'D.sup_nama')
					->join('po_laravel AS B', $i->table.'.po_id', '=', 'B.po_id')
					->join('permintaan_barang AS C', 'B.pb_id', '=', 'C.pb_id')
					->join('supplier_laravel AS D', 'C.sup_id', '=', 'D.sup_id')
					->where($i->table.'.visibility', 1);

		switch($type){
			case 'ppn' : $get->where('B.po_is_ppn', 1); break;
			case 'nppn': $get->where('B.po_is_ppn', 2); break;
		}

		return $get->whereMonth($i->table.'.pener_date', '=', $date['m'])
					->whereYear($i->table.'.pener_date', '=', $date['y'])
					->orderBy(($sortBy == 'pener_date' ? $i->table : 'D') . '.' . $sortBy, 'ASC')
					->get();
	}
	public static function fetchQaCheck($args){
		$i 		= new static;
		$get	= $i
			->select($i->table.'.'.$i->primaryKey, 'B.po_no', 'D.sup_nama', 'B.po_tgl_kedatangan', $i->table.'.pener_date')
			->join('po_laravel AS B', $i->table.'.po_id', '=', 'B.po_id')
			->join('permintaan_barang AS C', 'B.pb_id', '=', 'C.pb_id')
			->join('supplier_laravel AS D', 'C.sup_id', '=', 'D.sup_id')
			->where($i->table.'.qa_check', 1)
			->where($i->table.'.visibility', 1);

		if(! is_null($args['search']['s'])){
			switch($args['search']['field']){
				case 'po_no' 	: $prefix = 'B.'; break;
				case 'sup_nama'	: $prefix = 'D.'; break;
			}

			$get->where($prefix . $args['search']['field'], 'LIKE', '%' . $args['search']['s'] . '%');
		}

		return $get->orderBy($i->table.'.created_at', 'DESC')->paginate($args['perPage']);
	}

}