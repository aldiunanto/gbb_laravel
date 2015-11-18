<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\Assets;
use App\Models\Po as PoModel;
use App\Models\Po_sub;
use App\Models\Retur_penerimaan as Returpener;
use App\Models\Retur_penerimaan_sub as Returpeners;
use App\Models\Material;
use App\Models\Do_retur_penerimaan as DoReturpener;
use App\Models\Penerimaan as Pener;
use App\Models\Penerimaan_sub as Peners;

use Illuminate\Http\Request;

class Printing extends Controller {

	public function po($po_id)
	{
		$data = [
			'asset' => new Assets(),
			'title'	=> 'Print Purchasing Order',
			'head'	=> PoModel::getDetail($po_id),
			'sub'	=> Po_sub::fetchDetail($po_id)
		];

		return view('printing/po', $data);
	}
	public function deliveryOrder($returpener_id)
	{

		$get = DoReturpener::where('returpener_id', $returpener_id);
		if($get->count() == 0){
			if(DoReturpener::count() == 0){
				$numb = '001/JIU/' . romawi()[date('n')] . '/' . date('Y');
			}else{
				$last = DoReturpener::orderBy('dorp_id', 'DESC')->take(1)->pluck('dorp_no');
				$path = explode('/', $last);

				$preffix = ''; $path[0]++;
				for($x = 0; $x < (3 - strlen($path[0])); $x++){
					$preffix .= '0';
				}

				$numb = ($preffix . $path[0]) . '/JIU/' . romawi()[date('n')] . '/' . date('Y');
			}

			DoReturpener::create([
				'returpener_id'	=> $returpener_id,
				'dorp_no'		=> $numb
			]);
			
		}else{
			$row = $get->first();
			$numb = $row->dorp_no;
		}

		#Update status to 'DO has been created'
		$get = Returpener::find($returpener_id);
		
		$get->returpener_status = 6;
		$get->save();
		#End

		#Reduce material's stock
		$mats = Returpeners::getMatData($returpener_id);
		foreach($mats as $mat){

			if($mat->returpeners_is_reduced == 2) :
				#Reducing stock...
				$eachMat = Material::find($mat->mat_id);

				$eachMat->mat_stock_akhir = $eachMat->mat_stock_akhir - $mat->returpeners_jml;
				$eachMat->save();
				#End

				#Update is_reduced field
				$each = Returpeners::find($mat->returpeners_id);

				$each->returpeners_is_reduced = 1;
				$each->save();
				#End
			endif;

		}
		#End

		$data = [
			'asset' => new Assets(),
			'title'	=> 'Print Retur Delivery Order',
			'head'	=> Returpener::fetchHead($returpener_id),
			'sub'	=> Returpeners::fetch($returpener_id),
			'numb'	=> $numb
		];

		return view('printing/do', $data);
	}
	public function qualityplan(Request $req)
	{
		$data = [
			'asset'		=> new Assets(),
			'title'		=> 'Report Rencana Mutu',
			'fetchp'	=> PoModel::getByDate(['m' => $req->input('month'), 'y' => $req->input('year')], 'ppn'),
			'fetchn'	=> PoModel::getByDate(['m' => $req->input('month'), 'y' => $req->input('year')], 'nppn'),
			'Posub'		=> new Po_sub(),
			'Pener'		=> new Pener(),
			'Peners'	=> new Peners(),
			'period'	=> libMonths()[$req->input('month')] . ' ' . $req->input('year')
		];

		return view('printing/qualityplan', $data);
	}
	public function purchasemonthly(Request $req)
	{
		$data = [
			'title'		=> 'Laporan Pembelian Bulanan',
			'asset'		=> new Assets(),
			'period'	=> libMonths()[$req->input('month')] . ' ' . $req->input('year'),
			'fetchp'	=> Pener::purchasemonthly(['m' => $req->input('month'), 'y' => $req->input('year')], 'ppn', $req->input('sort_by')),
			'fetchn'	=> Pener::purchasemonthly(['m' => $req->input('month'), 'y' => $req->input('year')], 'nppn', $req->input('sort_by')),
			'Peners'	=> new Peners()
		];

		return view('printing/purchasemonthly', $data);
	}
	public function materialTransaction(Request $req)
	{
		$data = [
			'title'		=> 'Laporan Transaksi Material Bulanan',
			'asset'		=> new Assets(),
			'period'	=> libMonths()[$req->input('month')] . ' ' . $req->input('year'),
			'post'		=> $req->input()
		];

		return view('printing/materialTransaction', $data);
	}

}