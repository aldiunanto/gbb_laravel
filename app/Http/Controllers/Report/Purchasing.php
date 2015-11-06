<?php namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Libraries\Assets;

class Purchasing extends Controller {

	public function qualityplan()
	{
		$data = [
			'title'		=> 'Form Report Rencana Mutu',
			'asset'		=> new Assets(),
			'position'	=> ['report/purchasing/qualityplan' => 'Report Rencana Mutu'],
			'opened'	=> 'report',
			'months'	=> libMonths()
		];
		
		return view('report.purchasing.qualityplan', $data);
	}
	public function purchasemonthly()
	{
		$data = [
			'title'		=> 'Form Laporan Pembelian Bulanan',
			'asset'		=> new Assets(),
			'position'	=> ['report/purchasing/purchasemonthly' => 'Laporan Pembelian Bulanan'],
			'opened'	=> 'report',
			'months'	=> libMonths()
		];

		return view('report.purchasing.purchasemonthly', $data);
	}

}