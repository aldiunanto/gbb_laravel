<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retur_penerimaan_sub extends Model {

	protected	$table		= 'retur_penerimaan_sub_laravel';
	protected	$primaryKey	= 'returpeners_id';
	protected	$fillable	= ['returpener_id', 'peners_id', 'returpeners_jml', 'returpeners_reason'];
	public 		$timestamps	= false;

}