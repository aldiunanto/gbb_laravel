<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model {

	protected $table		= 'pengeluaran_laravel';
	protected $primaryKey	= 'pengel_id';
	protected $fillable		= ['deptbg_id', 'pengel_bpb', 'pengel_po', 'pengel_date', 'qa_check', 'visibility'];

	public static function fetch($args, $isTransacToday = false){
		$i 		= new static;
		$get	= self::select($i->table.'.*', 'B.deptbg_nama')
					->join('dept_bagian AS B', $i->table.'.deptbg_id', '=', 'B.deptbg_id')
					->where($i->table.'.visibility', 1);

		if($isTransacToday){
			$get->whereDate($i->table.'.created_at', '=', now());
		}
		if(! is_null($args['search']['s'])){
			switch($args['search']['field']){
				case 'deptbg_nama' : $preffix = 'B.'; break;
				default : $preffix = $i->table.'.'; break;
			}

			$get->where($preffix . $args['search']['field'], 'LIKE', '%' . $args['search']['s'] . '%');
		}

		return $get->orderBy($i->table.'.pengel_date', 'DESC')->paginate($args['perPage']);
	}
	public static function fetchRow($id){
		$i = new static;
		return self::select($i->table.'.pengel_po', $i->table.'.pengel_bpb', $i->table.'.pengel_date', 'B.deptbg_nama')
				->join('dept_bagian AS B', $i->table.'.deptbg_id', '=', 'B.deptbg_id')
				->where($i->table.'.'.$i->primaryKey, $id)
				->first();
	}
	public static function isDuplicate($bpb){
		return self::select('pengel_bpb')->where('pengel_bpb', $bpb)->count();
	}

}