<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model {

	protected $table		= 'pengeluaran_laravel';
	protected $primaryKey	= 'pengel_id';
	protected $fillable		= ['deptbg_id', 'pengel_bpb', 'pengel_po', 'pengel_date', 'visibility'];

	public static function fetch($args){
		$i 		= new static;
		$get	= self::select($i->table.'.*', 'B.deptbg_nama')
					->join('dept_bagian AS B', $i->table.'.deptbg_id', '=', 'B.deptbg_id')
					->where($i->table.'.visibility', 1);

		if(! is_null($args['search']['s'])){
			switch($args['search']['field']){
				case 'deptbg_nama' : $preffix = 'B.'; break;
				default : $preffix = $i->table.'.'; break;
			}

			$get->where($preffix . $args['search']['field'], 'LIKE', '%' . $args['search']['s'] . '%');
		}

		return $get->orderBy($i->table.'.pengel_date', 'DESC')->paginate($args['perPage']);
	}

}