<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penerimaan_sub extends Model {

	protected 	$table 		= 'penerimaan_sub_laravel';
	protected 	$primaryKey	= 'peners_id';
	protected 	$fillable	= ['pener_id', 'pos_id', 'peners_jml'];
	public 		$timestamps	= false;

	public static function fetchDetail($where = null){
		$i 		= new static;
		$query	= self::select('B.pener_id', 'B.pener_date', 'B.created_at', $i->table.'.'.$i->primaryKey, $i->table.'.peners_jml', 'E.pbs_jml', 'D.po_no', 'F.mat_id', 'F.mat_nama', 'F.mat_spesifikasi', 'G.mats_nama', 'H.wrn_nama')
					->join('penerimaan_laravel AS B', $i->table.'.pener_id', '=', 'B.pener_id')
					->join('po_sub_laravel AS C', $i->table.'.pos_id', '=', 'C.pos_id')
					->join('po_laravel AS D', 'C.po_id', '=', 'D.po_id')
					->join('permintaan_barang_sub AS E', 'C.pbs_id', '=', 'E.pbs_id')
					->join('material_laravel AS F', 'E.mat_id', '=', 'F.mat_id')
					->join('material_satuan AS G', 'F.matsp_id', '=', 'G.mats_id')
					->leftJoin('warna AS H', 'F.wrn_id', '=', 'H.wrn_id');

		if(! is_null($where)) $query->where($where);
					
		return $query->orderBy($i->table.'.'.$i->primaryKey)->get();
	}
	public static function partialForPrint($pos_id){
		$i = new static;
		return self::select($i->table.'.peners_jml', 'B.pener_date')
				->join('penerimaan_laravel AS B', $i->table.'.pener_id', '=', 'B.pener_id')
				->where($i->table.'.pos_id', $pos_id)
				->get();
	}
	public static function purchasemonthly($pener_id){
		$i = new static;
		return self::select($i->table.'.peners_jml', 'D.mat_nama', 'E.mats_nama')
				->join('po_sub_laravel AS B', $i->table.'.pos_id', '=', 'B.pos_id')
				->join('permintaan_barang_sub AS C', 'B.pbs_id', '=', 'C.pbs_id')
				->join('material_laravel AS D', 'C.mat_id', '=', 'D.mat_id')
				->join('material_satuan AS E', 'D.matsp_id', '=', 'E.mats_id')
				->where($i->table.'.pener_id', $pener_id)
				->orderBy($i->table.'.'.$i->primaryKey, 'ASC')
				->get();
	}
	public static function getQuantity($matId, $date){
		$i = new static;
		return self::select($i->table.'.peners_jml', 'E.mat_perbandingan')
				->join('penerimaan_laravel AS B', $i->table.'.pener_id', '=', 'B.pener_id')
				->join('po_sub_laravel AS C', $i->table.'.pos_id', '=', 'C.pos_id')
				->join('permintaan_barang_sub AS D', 'C.pbs_id', '=', 'D.pbs_id')
				->join('material_laravel AS E', 'D.mat_id', '=', 'E.mat_id')
				->where('B.pener_date', $date)
				->where('D.mat_id', $matId)
				->get();

		/*SELECT A.peners_jml
		FROM penerimaan_sub_laravel AS A
		INNER JOIN penerimaan_laravel AS B ON A.pener_id = B.pener_id
		INNER JOIN po_sub_laravel AS C ON A.pos_id = C.pos_id
		INNER JOIN permintaan_barang_sub AS D ON C.pbs_id = D.pbs_id
		WHERE D.mat_id = 461
			AND B.pener_date = '2015-8-26'*/
	}
	/*public static function cardStock($data){
		$i = new static;
		return self::select($i->table.'.peners_jml', 'F.mats_nama')
				->join('penerimaan_laravel AS B', $i->table.'.pener_id', '=', 'B.pener_id')
				->join('po_sub_laravel AS C', $i->table.'.pos_id', '=', 'C.pos_id')
				->join('permintaan_barang_sub AS D', 'C.pbs_id', '=', 'D.pbs_id')
				->join('material_laravel AS E', 'D.mat_id', '=', 'E.mat_id')
				->join('material_satuan AS F', 'E.matsp_id', '=', 'F.mats_id')
				->where('B.visibility', 1)
				->where('E.mat_id', $data['matId'])
				->whereBetween('B.pener_date', [$data['dStart'], $data['dEnd']])
				->orderBy('B.pener_date', 'ASC')
				->get();
	}*/
	public static function cardStock($matId, $date){
		$i = new static;
		return self::select($i->table.'.peners_jml', 'F.mats_nama')
				->join('penerimaan_laravel AS B', $i->table.'.pener_id', '=', 'B.pener_id')
				->join('po_sub_laravel AS C', $i->table.'.pos_id', '=', 'C.pos_id')
				->join('permintaan_barang_sub AS D', 'C.pbs_id', '=', 'D.pbs_id')
				->join('material_laravel AS E', 'D.mat_id', '=', 'E.mat_id')
				->join('material_satuan AS F', 'E.matsp_id', '=', 'F.mats_id')
				->where('B.visibility', 1)
				->where('E.mat_id', $matId)
				->where('B.pener_date', $date)
				->get();
	}

}

