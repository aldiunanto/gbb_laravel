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

}