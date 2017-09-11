<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Do_retur_penerimaan extends Model {

	protected 	$table		= 'do_retur_penerimaan';
	protected 	$primaryKey	= 'dorp_id';
	protected 	$fillable	= ['returpener_id', 'dorp_no', 'dorp_note'];
	public 		$timestamps	= false;

}