<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\Assets;

use App\Models\Penerimaan as Pener;

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
			'position'	=> ['checklist' => 'Checklist QA', 'checklist/index' => 'Penerimaan'],
			'fetch'		=> Pener::fetchQaCheck(['search' => $search, 'perPage' => $perPage]),
			'active'	=> 'default',
			'search'	=> $search,
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
