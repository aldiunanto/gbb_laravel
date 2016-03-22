<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Po_sub extends Model {

	protected $table		= 'po_sub_laravel';
	protected $primaryKey	= 'pos_id';
	protected $fillable		= ['po_id', 'pbs_id', 'pos_harga', 'pos_discount'];
	public $timestamps		= false;

	public static function fetchDetail($po_id){
		$i = new static;
		return self::select('B.pbs_jml', 'B.mat_id','D.mats_nama', 'C.mat_nama', 'E.wrn_nama', 'C.mat_spesifikasi', $i->table.'.pos_harga', $i->table.'.pos_discount', $i->table.'.'.$i->primaryKey,'F.mu_shortcut')
			->join('permintaan_barang_sub AS B', $i->table.'.pbs_id', '=', 'B.pbs_id')
			->join('material_laravel AS C', 'B.mat_id', '=', 'C.mat_id')
			->join('material_satuan AS D', 'C.matsp_id', '=', 'D.mats_id')
			->join('warna AS E', 'C.wrn_id', '=', 'E.wrn_id')
			->join('mata_uang AS F', 'C.mu_id', '=', 'F.mu_id')
			->where($i->table.'.po_id', $po_id)
			->get();
	}
	public static function fetch($args){
		$i 		= new static;
		$get	= self::select(
							$i->table.'.'.$i->primaryKey,
							'B.po_id', 'B.po_no', 'B.po_status',
							'B.po_tgl_kedatangan', 'D.mat_nama',
							'B.po_tgl_buat', 'C.pbs_jml',
							DB::raw('(SELECT MAX(pener_date) FROM penerimaan_laravel WHERE po_id = B.po_id LIMIT 1) AS pener_date')
						);

		if(! is_null($args['search'])){
			$get->where('B.po_no', 'LIKE', '%' . $args['search'] . '%')
		}

		$get->join('po_laravel AS B', $i->table.'.po_id', '=', 'B.po_id')
			->join('permintaan_barang_sub AS C', $i->table.'.pbs_id', '=', 'C.pbs_id')
			->join('material_laravel AS D', 'C.mat_id', '=', 'D.mat_id');

		return $get->orderBy('B.created_at', 'DESC')->paginate($args['perPage']);

		/*SELECT A.pos_id, B.po_id, B.po_no, B.po_status, B.po_tgl_kedatangan, D.mat_nama, B.po_tgl_buat, C.pbs_jml,
			(SELECT MAX(pener_date) FROM penerimaan_laravel WHERE po_id = B.po_id LIMIT 1) AS pener_date
		FROM po_sub_laravel AS A
		INNER JOIN po_laravel AS B ON A.po_id = B.po_id
		INNER JOIN permintaan_barang_sub AS C ON A.pbs_id = C.pbs_id
		INNER JOIN material_laravel AS D ON C.mat_id = D.mat_id
		ORDER BY A.pos_id DESC*/
	}

}