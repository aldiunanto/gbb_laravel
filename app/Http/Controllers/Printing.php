<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\Assets;
use App\Models\Po as PoModel;
use App\Models\Po_sub;
use App\Models\Retur_penerimaan as Returpener;
use App\Models\Retur_penerimaan_sub as Returpeners;

class Printing extends Controller {

	public function po($po_id){
		$data = [
			'asset' => new Assets(),
			'title'	=> 'Print Purchasing Order',
			'head'	=> PoModel::getDetail($po_id),
			'sub'	=> Po_sub::fetchDetail($po_id)
		];

		return view('printing/po', $data);
	}
	public function deliveryOrder($returpener_id){
		$get = Returpener::find($returpener_id);
		
		$get->returpener_status = 6;
		$get->save();

		$data = [
			'asset' => new Assets(),
			'title'	=> 'Print Retur Delivery Order',
			'head'	=> Returpener::fetchHead($returpener_id),
			'sub'	=> Returpeners::fetch($returpener_id)
		];

		return view('printing/do', $data);
	}

}