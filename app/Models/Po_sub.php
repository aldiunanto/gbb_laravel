<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

}