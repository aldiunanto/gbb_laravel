<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model {

	protected $table		= 'pengeluaran_laravel';
	protected $primaryKey	= 'pengel_id';
	protected $fillable		= ['deptbg_id', 'pengel_bpb', 'pengel_po', 'pengel_date', 'visibility'];

}