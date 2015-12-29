<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retur_penerimaan extends Model {

	protected	$table		= 'retur_penerimaan_laravel';
	protected	$primaryKey	= 'returpener_id';
	protected	$fillable	= ['userid_input', 'pener_id', 'returpener_status', 'returpener_vd_desc', 'visibility', 'is_closed'];

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
	public static function fetch($args){
		$i 		= new static;
		$get 	= self::select($i->table.'.'.$i->primaryKey, $i->table.'.returpener_status', 'C.po_no', 'E.sup_nama', 'B.pener_date', $i->table.'.created_at')
					->join('penerimaan_laravel AS B', $i->table.'.pener_id', '=', 'B.pener_id')
					->join('po_laravel AS C', 'B.po_id', '=', 'C.po_id')
					->join('permintaan_barang AS D', 'C.pb_id', '=', 'D.pb_id')
					->join('supplier_laravel AS E', 'D.sup_id', '=', 'E.sup_id')
					->where($i->table.'.visibility', 1);

		switch($args['role']){
			#case 1, 3, & 7 (admin, rawmat, and QA) let them know all of datas

			case 2: $get->whereIn($i->table.'.returpener_status', [5, 6]); break; //Purchasing
			case 4: $get->whereIn($i->table.'.returpener_status', [3, 4, 5, 6]); break; //PPIC
			case 5: $get->whereIn($i->table.'.returpener_status', [4, 5, 6]); break; //Vice Director
			case 6: $get->whereIn($i->table.'.returpener_status', [2, 3, 4, 5, 6]); break; //K.a Prod
		}

		if(! is_null($args['search']['s'])){
			switch($args['search']['field']){
				case 'po_no'	: $preffix = 'C'; break;
				case 'sup_nama'	: $preffix = 'E'; break;
			}

			$get->where($preffix.'.'.$args['search']['field'], 'LIKE', '%'.$args['search']['s'].'%');
		}

		return $get->orderBy($i->table.'.created_at', 'DESC')->paginate($args['perPage']);
	}
	public static function isRetur($pener_id){
		return self::select('returpener_id')->where('pener_id', $pener_id)->get()->count();
	}
	public static function openRetur($search = null){
		$i 		= new static;
		$get	= self::select($i->table.'.'.$i->primaryKey, $i->table.'.created_at', 'B.pener_date', 'C.po_no', 'D.dorp_no', 'F.sup_nama')
				->join('penerimaan_laravel AS B', $i->table.'.pener_id', '=', 'B.pener_id')
				->join('po_laravel AS C', 'B.po_id', '=', 'C.po_id')
				->join('do_retur_penerimaan AS D', $i->table.'.'.$i->primaryKey, '=', 'D.returpener_id')
				->join('permintaan_barang AS E', 'C.pb_id', '=', 'E.pb_id')
				->join('supplier_laravel AS F', 'E.sup_id', '=', 'F.sup_id')
				->where($i->table.'.visibility', 1);

		if(! is_null($search)){
			$get->where(function($query) use ($search){
				$query->orWhere('C.po_no', 'LIKE', '%' . $search . '%')
						->orWhere('D.dorp_no', 'LIKE', '%' . $search . '%');
			});
		}

		return $get->groupBy($i->table.'.'.$i->primaryKey)
					->orderBy($i->table.'.created_at', 'DESC')
					->take(20)
					->get();

	}
	public static function fetchAcceptanceReturHead($returpener_id){
		$i 		= new static;
		return self::select($i->table.'.'.$i->primaryKey, $i->table.'.created_at', $i->table.'.is_closed', 'B.pener_date', 'C.po_no', 'E.sup_nama', 'F.dorp_no')
				->join('penerimaan_laravel AS B', $i->table.'.pener_id', '=', 'B.pener_id')
				->join('po_laravel AS C', 'B.po_id', '=', 'C.po_id')
				->join('permintaan_barang AS D', 'C.pb_id', '=', 'D.pb_id')
				->join('supplier_laravel AS E', 'D.sup_id', '=', 'E.sup_id')
				->join('do_retur_penerimaan AS F', $i->table.'.'.$i->primaryKey, '=', 'F.'.$i->primaryKey)
				->where($i->table.'.'.$i->primaryKey, $returpener_id)
				->first();
	}

}