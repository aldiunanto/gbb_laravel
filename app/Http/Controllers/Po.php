<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Libraries\Assets;
use App\Models\Po as PoModel;
use App\Models\Po_sub;
use App\Models\Permintaan_barang as Pb;
use App\Models\Permintaan_barang_sub as Pbs;
use App\Models\Penerimaan_sub as Peners;
use Auth;
use Session;

use Illuminate\Http\Request;

class Po extends Controller {

	protected $role;

	public function __construct(){
		$this->role = Auth::user()->hak_akses;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $req)
	{
		$perPage	= 20;
		$search 	= [
			's'		=> ($req->has('s') ? $req->input('s') : null),
			'field'	=> ($req->has('field') ? $req->input('field') : null)
		];

		$data = [
			'title'		=> 'Data List PO',
			'asset'		=> new Assets(),
			'position'	=> ['po' => 'Purchasing Order'],
			'fetch'		=> Po_sub::fetch(['search' => $search, 'perPage' => $perPage]),
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
			},
			'search'	=> $search,
			'opened'	=> 'po',
			'role'		=> $this->role
		];

		# Pagination config
		$data['fetch']->setPath(url('po'));
		if($req->has('s')) $data['fetch']->appends(['field' => $search['field'], 's' => $search['s']]);
		# End of pagination config

		return view('po.index', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($pb_id)
	{
		$data = [
			'title'		=> 'Form Pembuatan PO',
			'asset'		=> new Assets(),
			'js'		=> ['vendor/jquery-ui-autocomplete-datepicker.min'],
			'css'		=> ['jquery-ui-autocomplete-datepicker.min'],
			'position'	=> ['po' => 'Purchasing Order', 'po/create/' . $pb_id => 'Buat PO'],
			'head'		=> Pb::fetchDetail($pb_id),
			'sub'		=> Pbs::fetchForPO($pb_id),
			'pb_id'		=> $pb_id
		];

		return view('po.create', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$po_no = trim($request->input('po_no'));
		$path = explode('/', $po_no);

		$values = [
			'pb_id'				=> $request->input('pb_id'),
			'po_no'				=> $po_no,
			'po_tgl_buat'		=> $request->input('po_tgl_buat'),
			'po_tgl_kedatangan'	=> $request->input('po_tgl_kedatangan'),
			'po_note'			=> trim($request->input('po_note')),
			'po_is_ppn'			=> ($path[0] == 'P' ? 1 : 2),
			'po_is_use_ppn'		=> $request->input('po_is_use_ppn'),
			'po_status'			=> 1,
			'po_sudden'			=> 2
		];

		$po = PoModel::create($values);

		for($x = 0; $x < count($_POST['pbs_id']); $x++){
			$values = [
				'po_id'			=> $po->po_id,
				'pbs_id'		=> $_POST['pbs_id'][$x],
				'pos_harga'		=> $_POST['pos_harga'][$x],
				'pos_discount'	=> $_POST['pos_discount'][$x]
			];

			Po_sub::create($values);
		}

		$pb = Pb::find($request->input('pb_id'));
		$pb->pb_status = 4;
		$pb->save();

		if(isset($_POST['save'])){
			Session::flash('inserted', '<div class="info success">PO dengan nomor <strong>' . $po_no . '</strong> berhasil dibuat.</div>');
			return redirect('po');
		}elseif(isset($_POST['save_print'])){
			return redirect('printing/po/' . $po->po_id);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$data = [
			'head'	=> PoModel::getDetail($id),
			'sub'	=> Po_sub::fetchDetail($id),
			'role'	=> $this->role
		];

		return view('po.show', $data);
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

	public function generateNumb()
	{
		$get = PoModel::generateNumb($_POST['type']);
		echo generatePoNumb($get);
	}
	public function matAcceptanceDetail($pos_id)
	{
		$data = [
			'head'	=> Peners::fetchDetail(['penerimaan_sub_laravel.pos_id' => $pos_id])->first(),
			'fetch'	=> Peners::fetchDetail(['penerimaan_sub_laravel.pos_id' => $pos_id])
		];

		return view('po.matAcceptanceDetail', $data);
	}
	public function acceptanceDetail($po_id)
	{
		$fetch = Peners::fetchDetail(['D.po_id' => $po_id]);	
		foreach($fetch as $row){
			if(! empty($item[$row->mat_id][$row->pener_date])){
				$item[$row->mat_id][$row->pener_date] += $row->peners_jml;
			}else{
				$item[$row->mat_id][$row->pener_date] = $row->peners_jml;	
			}
			
			$matNama[$row->mat_id] = $row->mat_nama;
			$matSpec[$row->mat_id] = $row->mat_spesifikasi;
			$pbsJml[$row->mat_id] = $row->pbs_jml;
		}

		$data = [
			'head'		=> PoModel::getDetail($po_id),
			'master' 	=> $item,
			'matNama'	=> $matNama,
			'matSpec'	=> $matSpec,
			'pbsJml'	=> $pbsJml,
			'role'		=> $this->role
		];

		return view('po.acceptanceDetail', $data);
	}

	public function closingForm()
	{
		return view('po.closingForm', ['po_id' => $_POST['poId']]);
	}
	public function closing(Request $req)
	{
		$get = PoModel::find($req->input('po_id'));

		$get->po_status = 2;
		$get->po_reason = trim($req->input('po_reason'));
		$get->save();

		Session::flash('inserted', '<div class="info success">PO dengan nomor <strong>' . $get->po_no . '</strong> sudah di-closing.</div>');
		return redirect('po');
	}

}
