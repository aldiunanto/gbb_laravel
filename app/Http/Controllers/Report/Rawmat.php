<?php namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Libraries\Assets;

class Rawmat extends Controller {

	public function materialTransaction()
	{
		$data = [
			'title'		=> 'Form Report Transaksi Material',
			'asset'		=> new Assets(),
			'position'	=> ['report/rawmat/materialTransaction' => 'Report Transaksi Material'],
			'opened'	=> 'report',
			'months' 	=> libMonths()
		];

		return view('report.rawmat.materialTransaction', $data);
	}
	public function monthly()
	{
		return 'Hello World';
	}

}