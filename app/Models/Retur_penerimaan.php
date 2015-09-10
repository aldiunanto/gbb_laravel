<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retur_penerimaan extends Model {

	protected	$table		= 'retur_penerimaan_laravel';
	protected	$primaryKey	= 'returpener_id';
	protected	$fillable	= ['userid_input', 'pener_id', 'returpener_status', 'visibility', 'created_at'];
	public 		$timestamps = false;

}