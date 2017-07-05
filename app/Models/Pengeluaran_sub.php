<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran_sub extends Model {

	protected 	$table		= 'pengeluaran_sub_laravel';
	protected 	$primaryKey	= 'pengels_id';
	protected 	$fillable	= ['pengel_id', 'mat_id', 'pengels_permintaan', 'pengels_realisasi', 'pengels_ket'];
	public 		$timestamps	= false;

	public static function fetch($pengel_id){
		$i = new static;
		return self::select('B.mat_nama', 'B.mat_spesifikasi', 'C.wrn_nama', 'D.mats_nama', $i->table.'.pengels_permintaan', $i->table.'.pengels_realisasi', $i->table.'.pengels_ket', 'E.sup_nama')
				->join('material_laravel AS B', $i->table.'.mat_id', '=', 'B.mat_id')
				->join('warna AS C', 'B.wrn_id', '=', 'C.wrn_id')
				->join('material_satuan AS D', 'B.matsr_id', '=', 'D.mats_id')
				->join('supplier_laravel AS E', 'B.sup_id', '=', 'E.sup_id')
				->where($i->table.'.pengel_id', $pengel_id)
				->get();
	}
	public static function getQuantity($matId, $date, $dYaMo = false, $dYaMoV = array()){ //dYaMo = Date Year and Moth Only. Extra 'V' = value
		$i 		= new static;
		$get 	= self::select($i->table.'.pengels_realisasi', 'B.pengel_date')
					->join('pengeluaran_laravel AS B', $i->table.'.pengel_id', '=', 'B.pengel_id')
					->where($i->table.'.mat_id', $matId);

		if($dYaMo){
			$get->whereYear('B.pengel_date', '=', $dYaMoV[0])
				->whereMonth('B.pengel_date', '=', $dYaMoV[1]);
		}else{
			$get->where('B.pengel_date', $date);
		}
	
		return $get->get();
	}
	/*public static function cardStock($data){
		$i = new static;
		return self::select($i->table.'.pengels_realisasi', 'D.mats_nama')
				->join('pengeluaran_laravel AS B', $i->table.'.pengel_id', '=', 'B.pengel_id')
				->join('material_laravel AS C', $i->table.'.mat_id', '=', 'C.mat_id')
				->join('material_satuan AS D', 'C.matsr_id', '=', 'D.mats_id')
				->where('B.visibility', 1)
				->where($i->table.'.mat_id', $data['matId'])
				->whereBetween('B.pengel_date', [$data['dStart'], $data['dEnd']])
				->orderBy('B.pengel_date', 'ASC')
				->get();
	}*/
	public static function cardStock($matId, $date){
		$i = new static;
		return self::select($i->table.'.pengels_realisasi', 'B.pengel_bpb', 'D.mats_nama', 'E.deptbg_nama')
				->join('pengeluaran_laravel AS B', $i->table.'.pengel_id', '=', 'B.pengel_id')
				->join('material_laravel AS C', $i->table.'.mat_id', '=', 'C.mat_id')
				->join('material_satuan AS D', 'C.matsr_id', '=', 'D.mats_id')
				->join('dept_bagian AS E', 'B.deptbg_id', '=', 'E.deptbg_id')
				->where('B.visibility', 1)
				->where($i->table.'.mat_id', $matId)
				->where('B.pengel_date', $date)
				->get();
	}

}