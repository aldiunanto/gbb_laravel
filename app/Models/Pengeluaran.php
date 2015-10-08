<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model {

	protected $table		= 'pengeluaran_laravel';
	protected $primaryKey	= 'pengel_id';
	protected $fillable		= ['deptbg_id', 'pengel_bpb', 'pengel_po', 'pengel_date', 'visibility'];

	public static function fetch(){
		$i = new static;
		return self::select($i->table.'.*', 'B.deptbg_nama')
					->join('dept_bagian AS B', $i->table.'.deptbg_id', '=', 'B.deptbg_id')
					->where($i->table.'.visibility', 1)
					->orderBy($i->table.'.pengel_date', 'DESC')
					->get();
	}

}