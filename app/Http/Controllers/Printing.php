<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\Assets;
use App\Models\Po as PoModel;
use App\Models\Po_sub;
use App\Models\Retur_penerimaan as Returpener;

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
		$data = [
			'asset' => new Assets(),
			'title'	=> 'Print Retur Delivery Order',
			'head'	=> Returpener::fetchHead($returpener_id)
		];

		return view('printing/do', $data);
	}

}