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

		/*SELECT B.pener_id, B.pener_date, B.created_at, A.peners_jml, E.pbs_jml, D.po_id, D.po_no, F.mat_id, F.mat_nama, F.mat_spesifikasi, G.mats_nama, H.wrn_nama
		FROM penerimaan_sub_laravel AS A
		INNER JOIN penerimaan_laravel AS B ON A.pener_id = B.pener_id
		INNER JOIN po_sub_laravel AS C ON A.pos_id = C.pos_id
		INNER JOIN po_laravel AS D ON C.po_id = D.po_id
		INNER JOIN permintaan_barang_sub AS E ON C.pbs_id = E.pbs_id
		INNER JOIN material_laravel AS F ON E.mat_id = F.mat_id
		INNER JOIN material_satuan AS G ON F.matsp_id = G.mats_id
		LEFT JOIN warna AS H ON F.wrn_id = H.wrn_id*/
	}

}

