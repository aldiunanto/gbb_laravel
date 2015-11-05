<?php namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Libraries\Assets;

class Purchasing extends Controller {

	public function rencanamutu()
	{
		$data = [
			'title'		=> 'Form Report Rencana Mutu',
			'asset'		=> new Assets(),
			'position'	=> ['report/purchasing/rencanamutu' => 'Report Rencana Mutu'],
			'opened'	=> 'report',
			'months'	=> libMonths()
		];
		
		return view('report.purchasing.rencanamutu', $data);
	}

}