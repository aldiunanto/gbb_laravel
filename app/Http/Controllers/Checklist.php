<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\Assets;

use App\Models\Penerimaan as Pener;
use App\Models\Penerimaan_sub as Peners;
use App\Models\Penerimaan_returan as Peneretur;
use App\Models\Pengeluaran as Pengel;

class Checklist extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $req)
	{
		$perPage 	= 20;
		$search 	= [
			's'		=> ($req->has('s') ? $req->input('s') : null),
			'field'	=> ($req->has('field') ? $req->input('field') : null)
		];

		$data = [
			'title'		=> 'Checklist QA - Penerimaan Material',
			'asset'		=> new Assets(),
			'position'	=> ['checklist' => 'Checklist QA', 'checklist/' => 'Penerimaan'],
			'fetch'		=> Pener::fetchQaCheck(['search' => $search, 'perPage' => $perPage]),
			'active'	=> 'default',
			'search'	=> $search,
			'count'		=> [
				'pener'		=> Pener::where(['qa_check' => 1, 'visibility' => 1])->count(),
				'peneretur'	=> Peneretur::where(['qa_check' => 1, 'visibility' => 1])->count(),
				'pengel'	=> Pengel::where(['qa_check' => 1, 'visibility' => 1])->count()
			],
			'getNumb'	=> function() use ($perPage, $req){
				if($req->has('page') && $req->input('page') != 1){
					return ($req->input('page') * $perPage) - $perPage;
				}else{
					return 0;
				}
			},
			'isSelected'=> function($field) use($search){
				if(! is_null($search['field'])){
					if($search['field'] == $field) return 'selected="selected"';
				}
			}
		];

		# Pagination config
		$data['fetch']->setPath(url('checklist'));
		if($req->has('s')) $data['fetch']->appends(['field' => $search['field'], 's' => $search['s']]);
		# End of pagination config

		return view('checklist.baseFrame', $data)->nest('dataListContent', 'checklist.index', $data);
	}
	public function acceptanceShow($penerId)
	{
		$data = [
			'head'	=> Pener::fetchHead($penerId),
			'sub'	=> Peners::fetchDetail(['B.pener_id' => $penerId])
		];

		return view('checklist.acceptanceShow', $data);
	}
	public function acceptanceCheck(Request $req, $penerId)
	{
		$row = Pener::find($penerId);

		$row->qa_check = 2;
		$row->save();

		$req->session()->flash('message', '<div class="info success">Check Penerimaan Barang berhasil.</div>');
		return redirect('checklist');
	}
	public function acceptanceRetur(Request $req)
	{
		$perPage	= 20;
		$search 	= [
			's'		=> ($req->has('s') ? $req->input('s') : null),
			'field'	=> ($req->has('field') ? $req->input('field') : null)
		];

		$data = [
			'title'		=> 'Checklist QA - Penerimaan Returan Material',
			'asset'		=> new Assets(),
			'position'	=> ['checklist' => 'Checklist QA', 'checklist/acceptance-retur' => 'Penerimaan Retur'],
			'active'	=> 'retur',
			'fetch'		=> Peneretur::fetch(['search' => $search, 'perPage' => $perPage]),
			'search'	=> $search,
			'count'		=> [
				'pener'		=> Pener::where(['qa_check' => 1, 'visibility' => 1])->count(),
				'peneretur'	=> Peneretur::where(['qa_check' => 1, 'visibility' => 1])->count(),
				'pengel'	=> Pengel::where(['qa_check' => 1, 'visibility' => 1])->count()
			],
			'getNumb'	=> function() use ($perPage, $req){
				if($req->has('page') && $req->input('page') != 1){
					return ($req->input('page') * $perPage) - $perPage;
				}else{
					return 0;
				}
			},
			'isSelected'=> function($field) use($search){
				if(! is_null($search['field'])){
					if($search['field'] == $field) return 'selected="selected"';
				}
			}
		];

		# Pagination config
		$data['fetch']->setPath(url('check/acceptance-retur'));
		if($req->has('s')) $data['fetch']->appends(['field' => $search['field'], 's' => $search['s']]);
		# End of pagination config

		return view('checklist.baseFrame', $data)->nest('dataListContent', 'checklist.acceptanceRetur', $data);
	}
	public function acceptanceReturCheck(Request $req, $penereturId)
	{
		$row = Peneretur::find($penereturId);

		$row->qa_check = 2;
		$row->save();

		$req->session()->flash('message', '<div class="info success">Check Penerimaan Returan berhasil.</div>');
		return redirect('checklist/acceptance-retur');
	}
	public function expenditure(Request $req)
	{
		$perPage	= 20;
		$search  	= [
			's'		=> ($req->has('s') ? $req->input('s') : null),
			'field'	=> ($req->has('field') ? $req->input('field') : null)
		];

		$data = [
			'title'		=> 'Checklist QA - Daftar Pengeluaran Material',
			'asset'		=> new Assets(),
			'position'	=> ['checklist' => 'Checklist QA', 'checklist/expenditure' => 'Pengeluaran'],
			'search'	=> $search,
			'active'	=> 'expenditure',
			'js'		=> ['vendor/jquery-ui-autocomplete-datepicker.min'],
			'css'		=> ['jquery-ui-autocomplete-datepicker.min'],
			'fetch'		=> Pengel::fetch(['search' => $search, 'perPage' => $perPage]),
			'count'		=> [
				'pener'		=> Pener::where(['qa_check' => 1, 'visibility' => 1])->count(),
				'peneretur'	=> Peneretur::where(['qa_check' => 1, 'visibility' => 1])->count(),
				'pengel'	=> Pengel::where(['qa_check' => 1, 'visibility' => 1])->count()
			],
			'isSelected'=> function($field) use($search){
				if(! is_null($search['field'])){
					if($search['field'] == $field) return 'selected="selected"';
				}
			},
			'getNumb'	=> function() use ($perPage, $req){
				if($req->has('page') && $req->input('page') != 1){
					return ($req->input('page') * $perPage) - $perPage;
				}else{
					return 0;
				}
			}
		];

		# Pagination config
		$data['fetch']->setPath(url('checklist/expenditure'));
		if($req->has('s')) $data['fetch']->appends(['field' => $search['field'], 's' => $search['s']]);
		# End of pagination config

		return view('checklist.baseFrame', $data)->nest('dataListContent', 'checklist.expenditure', $data);
	}
	public function expenditureCheck(Request $req, $pengelId)
	{
		$row = Pengel::find($pengelId);

		$row->qa_check = 2;
		$row->save();

		$req->session()->flash('message', '<div class="info success">Check Pengeluaran Material berhasil.</div>');
		return redirect('checklist/expenditure');
	}

}
