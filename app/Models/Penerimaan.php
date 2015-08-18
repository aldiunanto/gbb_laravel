<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Penerimaan extends Model {

	protected	$table		= 'penerimaan_laravel';
	protected	$primaryKey	= 'pener_id';
	protected	$fillable	= ['po_id', 'pener_date', 'userid_input', 'visibility'];
	public 		$timestamps	= true;

	public static function fetchData($args){
		$i = new static;
		$get = self::select($i->table.'.'.$i->primaryKey, 'B.po_id', 'B.po_no', 'B.po_tgl_kedatangan', DB::raw('MAX('.$i->table.'.pener_date) AS pener_date'))
					->join('po_laravel AS B', $i->table.'.po_id', '=', 'B.po_id')
					->where($i->table.'.visibility', 1)
					->groupBy($i->table.'.po_id');

		return $get->orderBy($i->table.'.pener_date', 'DESC')->paginate($args['perPage']);
	}
	public static function fetchAll($po_id){
		return self::select('pener_id', 'pener_date')
					->where('po_id', $po_id)
					->where('visibility', 1)
					->orderBy('pener_date', 'ASC')
					->get();
	}

}