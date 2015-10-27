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
			'months'	=> [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember']
		];
		
		return view('report.purchasing.rencanamutu', $data);
	}

}