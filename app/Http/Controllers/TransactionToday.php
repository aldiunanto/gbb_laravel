<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\Assets;

use App\Models\Penerimaan as Pener;
use App\Models\Penerimaan_sub as Peners;
use App\Models\Penerimaan_returan as Peneretur;
use App\Models\Pengeluaran as Pengel;

class TransactionToday extends Controller {

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
			'title'		=> 'Transaksi Hari Ini - Penerimaan Material',
			'asset'		=> new Assets(),
			'position'	=> ['transaction-today' => 'Transaksi Hari Ini', 'transaction-today/' => 'Penerimaan'],
			'fetch'		=> Pener::fetchTransacToday(['search' => $search, 'perPage' => $perPage]),
			'active'	=> 'default',
			'search'	=> $search,
			'count'		=> [
				'pener'		=> Pener::where('visibility', 1)->whereDate('created_at', '=', now())->count(),
				'peneretur'	=> Peneretur::where('visibility', 1)->whereDate('created_at', '=', now())->count(),
				'pengel'	=> Pengel::where('visibility', 1)->whereDate('created_at', '=', now())->count()
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
		$data['fetch']->setPath(url('transaction-today'));
		if($req->has('s')) $data['fetch']->appends(['field' => $search['field'], 's' => $search['s']]);
		# End of pagination config

		return view('transaction-today.baseFrame', $data)->nest('dataListContent', 'transaction-today.index', $data);
	}
	public function acceptanceRetur(Request $req)
	{
		$perPage	= 20;
		$search 	= [
			's'		=> ($req->has('s') ? $req->input('s') : null),
			'field'	=> ($req->has('field') ? $req->input('field') : null)
		];

		$data = [
			'title'		=> 'Transaksi Hari Ini - Penerimaan Returan Material',
			'asset'		=> new Assets(),
			'position'	=> ['transaction-today' => 'Transaksi Hari Ini', 'transaction-today/acceptance-retur' => 'Penerimaan Retur'],
			'active'	=> 'retur',
			'fetch'		=> Peneretur::fetch(['search' => $search, 'perPage' => $perPage], true),
			'search'	=> $search,
			'count'		=> [
				'pener'		=> Pener::where('visibility', 1)->whereDate('created_at', '=', now())->count(),
				'peneretur'	=> Peneretur::where('visibility', 1)->whereDate('created_at', '=', now())->count(),
				'pengel'	=> Pengel::where('visibility', 1)->whereDate('created_at', '=', now())->count()
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
		$data['fetch']->setPath(url('transaction-today/acceptance-retur'));
		if($req->has('s')) $data['fetch']->appends(['field' => $search['field'], 's' => $search['s']]);
		# End of pagination config

		return view('transaction-today.baseFrame', $data)->nest('dataListContent', 'transaction-today.acceptanceRetur', $data);
	}
	public function expenditure(Request $req)
	{
		$perPage	= 20;
		$search  	= [
			's'		=> ($req->has('s') ? $req->input('s') : null),
			'field'	=> ($req->has('field') ? $req->input('field') : null)
		];

		$data = [
			'title'		=> 'Transaksi Hari Ini - Daftar Pengeluaran Material',
			'asset'		=> new Assets(),
			'position'	=> ['transaction-today' => 'Transaksi Hari ini', 'transaction-today/expenditure' => 'Pengeluaran'],
			'search'	=> $search,
			'active'	=> 'expenditure',
			'js'		=> ['vendor/jquery-ui-autocomplete-datepicker.min'],
			'css'		=> ['jquery-ui-autocomplete-datepicker.min'],
			'fetch'		=> Pengel::fetch(['search' => $search, 'perPage' => $perPage], true),
			'count'		=> [
				'pener'		=> Pener::where('visibility', 1)->whereDate('created_at', '=', now())->count(),
				'peneretur'	=> Peneretur::where('visibility', 1)->whereDate('created_at', '=', now())->count(),
				'pengel'	=> Pengel::where('visibility', 1)->whereDate('created_at', '=', now())->count()
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
		$data['fetch']->setPath(url('transaction-today/expenditure'));
		if($req->has('s')) $data['fetch']->appends(['field' => $search['field'], 's' => $search['s']]);
		# End of pagination config

		return view('transaction-today.baseFrame', $data)->nest('dataListContent', 'transaction-today.expenditure', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
