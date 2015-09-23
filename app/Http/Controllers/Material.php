<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Libraries\Assets;
use App\Models\Material as MatModel;
use App\Models\Mata_uang as MuModel;
use App\Models\Warna;
use App\Models\Material_satuan as Mats;
use App\Models\Permintaan_barang as Pb;
use App\Models\Permintaan_barang_sub as Pbs;
use App\Models\Penerimaan as Pener;
use App\Models\Penerimaan_sub as Peners;
use App\Models\Po;
use App\Models\Po_sub;
use App\Models\Notification as Notif;
use App\Models\Supplier as Supp;
use App\Models\Retur_penerimaan as Returpener;
use App\Models\Retur_penerimaan_sub as Returpeners;
use Validator;
use Session;
use Auth;

use Illuminate\Http\Request;

class Material extends Controller {

	private $_user;

	public function __construct(){
		$this->_user = Auth::user();
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$perPage	= 20;
		$search 	= [
			's'		=> ($request->has('s') ? $request->input('s') : null),
			'field'	=> ($request->has('field') ? $request->input('field') : null)
		];
		$data = [
			'title'		=> 'Data List Material',
			'asset'		=> new Assets(),
			'position'	=> ['material' => 'Material'],
			'fetch'		=> MatModel::fetchData(['search' => $search, 'perPage' => $perPage]),
			'search'	=> $search,
			'opened'	=> 'material',
			'hak_akses'	=> $this->_user->hak_akses,
			'getNumb'	=> function() use ($perPage, $request){
				if($request->has('page') && $request->input('page') != 1){
					return ($request->input('page') * $perPage) - $perPage;
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
		$data['fetch']->setPath(url('material'));
		if($request->has('s')) $data['fetch']->appends(['field' => $search['field'], 's' => $search['s']]);
		# End of pagination config

		return view('material.index', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$role = $this->_user->hak_akses;
		if($role == 2){
			$accessable = ['', '', '', '', '', '', 'disabled="disabled"', 'disabled="disabled"', 'disabled="disabled"', 'disabled="disabled"', 'disabled="disabled"'];
		}elseif($role == 3){
			$accessable = ['', '', '', 'disabled="disabled"', 'disabled="disabled"', '', '', '', '', '', ''];
		}else{
			$accessable = ['', '', '', '', '', '', '', '', '', '', ''];
		}

		$data = [
			'title'		=> 'Tambah Data Material',
			'asset'		=> new Assets(),
			'opened'	=> 'material',
			'position'	=> ['material' => 'Material', 'material/create' => 'Input data baru'],
			'matauang'	=> MuModel::all(),
			'warna'		=> Warna::orderBy('wrn_nama')->get(),
			'mats'		=> Mats::orderBy('mats_nama')->get(),
			'accessable'=> $accessable
		];

		return view('material.create', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$validate = Validator::make($request->all(), [
			'mat_nama'	=> 'required',
			'sup_id'	=> 'required',
			'mat_harga'	=> 'required|numeric',
			'mu_id'		=> 'required',
			'wrn_id'	=> 'required',
			'matsp_id'	=> 'required'
		]);

		$validate->setAttributeNames(['mat_nama' => 'Nama Material', 'sup_id' => 'Supplier', 'mat_harga' => 'Harga', 'mu_id' => 'Mata Uang', 'wrn_id' => 'Warna', 'matsp_id' => 'Satuan Purchasing']);
		if($validate->fails()){
			return redirect('material/create')
					->withErrors($validate->errors())
					->withInput($request->all());
		}

		$values = [
			'matsr_id'			=> $request->input('matsr_id'),
			'matsp_id'			=> $request->input('matsp_id'),
			'wrn_id'			=> $request->input('wrn_id'),
			'sup_id'			=> $request->input('sup_id'),
			'mu_id'				=> $request->input('mu_id'),
			'mat_nama'			=> trim($request->input('mat_nama')),
			'mat_spesifikasi'	=> trim($request->input('mat_spesifikasi')),
			'mat_harga'			=> trim($request->input('mat_harga')),
			'mat_perbandingan' 	=> (empty($_POST['mat_perbandingan']) ? 1 : trim($request->input('mat_perbandingan'))),
			'mat_stock_min'		=> trim($request->input('mat_stock_min')),
			'mat_stock_awal'	=> trim($request->input('mat_stock_awal')),
			'mat_stock_akhir'	=> trim($request->input('mat_stock_akhir')),
			'visibility'		=> 1
		];
		MatModel::create($values);

		Session::flash('inserted', '<div class="info success">Data material baru berhasil ditambahkan.</div>');
		return redirect('material');
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
			'row'	=> MatModel::getDetail($id),
			'role'	=> $this->_user->hak_akses
		];

		return view('material.show', $data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, $is_price = null)
	{
		if(! is_null($is_price)){
			$data = [
				'title'		=> 'Ubah Harga Material',
				'asset'		=> new Assets(),
				'position'	=> ['material' => 'Material', 'material/edit/'.$id.'/price' => 'Ubah Harga'],
				'opened'	=> 'material',
				'head'		=> Supp::find($id),
				'fetch'		=> MatModel::forSupplierDetail($id)
			];

			return view('material.editPrice', $data);
		}


		$role = $this->_user->hak_akses;
		switch($role){
			case 1 : //admin
				$accessable = ['', '', '', '', '', '', '', '', '', '', ''];	
			break;
			case 2 : //purchasing
				$accessable = ['', '', '', '', '', '', 'disabled="disabled"', 'disabled="disabled"', 'disabled="disabled"', 'disabled="disabled"', 'disabled="disabled"'];	
			break;
			case 3 : //rawmat
				$accessable = ['disabled="disabled"', 'disabled="disabled"', 'disabled="disabled"', 'disabled="disabled"', 'disabled="disabled"', 'disabled="disabled"', '', '', '', '', ''];	
			break;
			case 4 : //PPIC
				$accessable = ['disabled="disabled"', 'disabled="disabled"', 'disabled="disabled"', 'disabled="disabled"', 'disabled="disabled"', 'disabled="disabled"', '', '', '', '', ''];
			break;
			case 5 : //Vice Director
				$accessable = ['', '', '', '', '', '', '', '', '', '', ''];
			break;
		}

		$data = [
			'title'		=> 'Ubah Data Material',
			'asset'		=> new Assets(),
			'position'	=> ['material' => 'Material', 'material/edit/'.$id => 'Ubah Data'],
			'matauang'	=> MuModel::all(),
			'warna'		=> Warna::orderBy('wrn_nama')->get(),
			'mats'		=> Mats::orderBy('mats_nama')->get(),
			'accessable'=> $accessable,
			'opened'	=> 'material',
			'row'		=> MatModel::getEditData($id),
			'role'		=> $role
		];

		return view('material.edit', $data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request)
	{
		if($request->input('method') && $request->input('method') == 'price'){
			$x = 0;
			foreach($_POST['mat_id'] as $mat_id){
				$get = MatModel::find($mat_id);

				$get->mat_harga = trim($_POST['mat_price'][$x]);
				$get->save();

				$x++;
			}

			Session::flash('updated', '<div class="info success">Data harga berhasil diubah.</div>');
			return redirect('material/edit/' . $request->input('sup_id') . '/price');
		}else{
			$mat_id = $request->input('mat_id');
			$role	= $this->_user->hak_akses;

			$mat = MatModel::find($mat_id);

			if($role == 3 || $role == 1){
				$mat->matsr_id 			= $request->input('matsr_id');
				$mat->mat_stock_min		= trim($request->input('mat_stock_min'));
				$mat->mat_perbandingan	= (empty($_POST['mat_perbandingan']) ? 1 : trim($request->input('mat_perbandingan')));
				$mat->mat_stock_awal	= trim($request->input('mat_stock_awal'));
				$mat->mat_stock_akhir	= trim($request->input('mat_stock_akhir'));
			}

			if($role == 2 || $role == 1){
				$mat->matsp_id			= $request->input('matsp_id');
				$mat->wrn_id			= $request->input('wrn_id');
				$mat->sup_id 			= $request->input('sup_id');
				$mat->mu_id 			= $request->input('mu_id');
				$mat->mat_nama 			= trim($request->input('mat_nama'));
				$mat->mat_spesifikasi	= trim($request->input('mat_spesifikasi'));
				$mat->mat_harga			= trim($request->input('mat_harga'));
			}

			$mat->save();

			Session::flash('updated', '<div class="info success">Data berhasil diubah.</div>');
			return redirect('material/edit/' . $mat_id);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$mat = MatModel::find($id);

		$mat->visibility = 0;
		$mat->save();

		Session::flash('deleted', '<div class="info warning">Data Material telah dihapus.</div>');
		return redirect('material');
	}

	public function request(Request $request)
	{
		$perPage	= 20;
		$s 			= ($request->has('s') ? $request->input('s') : null);
		$role		= $this->_user->hak_akses;

		$data = [
			'title'		=> 'Daftar Permintaan Barang',
			'asset'		=> new Assets(),
			'position'	=> ['material' => 'Material', 'material/request' => 'Permintaan Barang'],
			'fetchData'	=> Pb::fetchData(['role' => $role, 's' => $s, 'perPage' => $perPage]),
			'fetchReq'	=> Pb::fetchReq($role),
			's'			=> $s,
			'opened'	=> 'material',
			'hak_akses'	=> $role,
			'getNumb'	=> function() use ($perPage, $request){
				if($request->has('page') && $request->input('page') != 1){
					return ($request->input('page') * $perPage) - $perPage;
				}else{
					return 0;
				}
			}
		];	

		# Pagination config
		$data['fetchData']->setPath(url('material/request'));
		if($request->has('s')) $data['fetchData']->appends(['s' => $s]);
		# End of pagination config

		return view('material.request.index', $data);
	}
	public function requestShow($pb_id)
	{
		$data = [
			'row'	=> Pb::fetchDetail($pb_id),
			'list'	=> Pbs::fetchDetail($pb_id),
			'role'	=> $this->_user->hak_akses
		];

		return view('material.request.show', $data);
	}
	public function requestDestroy($pb_id)
	{
		$pb = Pb::find($pb_id);

		$pb->visibility = 0;
		$pb->save();

		Session::flash('deleted', '<div class="info warning">Permintaan Barang telah dihapus.</div>');
		return redirect('material/request');
	}
	public function requestAccept($pb_id)
	{
		$req = Pb::find($pb_id);

		switch($req->pb_status){
			case 1 : //approved by PPIC
				$set = 2;
				$req->ppic_approved_at = now(true);
			break;
			case 2 : //approved by Vice Director
				$set = 3;
				$req->vd_approved_at = now(true);
			break;
		}

		$req->pb_status = $set;
		$req->save();

		Session::flash('accepted', '<div class="info success">Permintaan telah di-approve.</div>');
		return redirect('material/request');
	}
	public function requestGetRejectForm()
	{
		return view('material.request.get_reject_form', ['pb_id' => $_POST['pb_id']]);
	}
	public function requestReject(Request $request)
	{
		$once = Pb::find($request->input('pb_id'));

		$once->pb_alasan_tolak 	= trim($request->input('pb_alasan_tolak'));
		$once->pb_role_tolak	= $this->_user->hak_akses;
		$once->userid_reject	= $this->_user->user_id;
		$once->pb_status		= 5;

		$once->save();
	}
	public function requestCreate()
	{
		$get = Pb::select('pb_no')->orderBy('created_at', 'DESC');
		if($get->count() == 0){
			$numb = 'GBB/001/' . romawi()[date('n')] . '/' . date('y');
		}else{
			$row = $get->first();
			$path = explode('/', $row->pb_no);

			if(date('y') == ($path[3] + 1)){
				$numb = $path[0] . '/' . '001' . '/' . romawi()[date('n')] . '/' . date('y');
			}else{
				$preffix = ''; $path[1]++;
				for($x = 0; $x < (3 - strlen($path[1])); $x++){
					$preffix .= '0';
				}

				$numb = $path[0] . '/' . ($preffix . $path[1]) . '/' . romawi()[date('n')] . '/' . date('y');
			}
		}


		$data = [
			'title'		=> 'Buat Permintaan Baru',
			'asset'		=> new Assets(),
			'js'		=> ['vendor/jquery-ui-autocomplete-datepicker.min'],
			'css'		=> ['jquery-ui-autocomplete-datepicker.min'],
			'position'	=> ['material' => 'Material', 'material/request' => 'Permintaan Barang', 'material/request/create' => 'Buat Permintaan'],
			'opened'	=> 'material',
			'lastNumb'	=> $numb
		];

		return view('material.request.create', $data);
	}
	public function requestGetData()
	{
		$data['fetch'] = MatModel::getData($_POST['sup_id']);
		return view('material.request.getData', $data);
	}
	public function getDetailItem()
	{
		$row = MatModel::getDetail($_POST['mat_id']);
		echo json_encode($row);
	}
	public function getRowItem()
	{
		return view('material.request.getRowItem');
	}
	public function requestStore(Request $req)
	{
		$values = [
			'sup_id'		=> $req->input('sup_id'),
			'pb_no'			=> trim($req->input('pb_no')),
			'pb_tgl_butuh'	=> $req->input('pb_tgl_butuh'),
			'pb_note'		=> trim($req->input('pb_note')),
			'visibility'	=> 1,
			'userid_input'	=> $this->_user->user_id
		];

		#pb_status, wether sudden-PO or not
		$values['pb_status'] = ($req->input('create_po') == 1 ? 4 : 1);
		#End of sudden-PO

		$pb = Pb::create($values);

		#If sudden-PO then create PO head directly and a notification
		if($req->input('create_po') == 1){

			$get = Po::generateNumb('non');
			$values = [
				'pb_id'				=> $pb->pb_id,
				'po_no'				=> generatePoNumb($get),
				'po_tgl_buat'		=> now(),
				'po_tgl_kedatangan'	=> $req->input('pb_tgl_butuh'),
				'po_is_ppn'			=> 2,
				'po_status'			=> 1,
				'po_sudden'			=> 1
			];
			$po = Po::create($values);

			$values = [
				'gn_desc'	=> 'Pembuatan <i>Sudden-PO</i> oleh Rawmat dengan nomor PO: <strong>' . $po->po_no . '</strong>',
				'gn_date'	=> now(true),
				'gn_role'	=> 2,
				'gn_read'	=> 2
			];
			Notif::create($values);

		}
		#Endif

		$x = 0;
		foreach($_POST['mat_id'] as $val){
			$values = [
				'pb_id'		=> $pb->pb_id,
				'mat_id'	=> $val,
				'pbs_jml'	=> $_POST['pbs_jml'][$x]
			];

			$pbs = Pbs::create($values);

			#If sudden-PO then create PO sub directly
			if($req->input('create_po') == 1){
				$values = [
					'po_id'		=> $po->po_id,
					'pbs_id'	=> $pbs->pbs_id,
					'pos_harga'	=> $_POST['mat_harga'][$x]
				];

				Po_sub::create($values);
			}
			#Endif

			$x++;
		}

		if($req->input('create_po') == 1){
			$message = 'Permintaan material telah dibuat berikut PO-nya dengan nomor: <strong>' . $po->po_no . '</strong>';
		}else{
			$message = 'Permintaan material telah dibuat.';
		}
		
		Session::flash('inserted', '<div class="info success">' . $message . '</div>');
		return redirect('material/request');
	}
	public function requestEdit($pb_id)
	{
		$data = [
			'title'		=> 'Ubah Permintaan Barang',
			'asset'		=> new Assets(),
			'js'		=> ['vendor/jquery-ui-autocomplete-datepicker.min'],
			'css'		=> ['jquery-ui-autocomplete-datepicker.min'],
			'position'	=> ['material' => 'Material', 'material/request' => 'Permintaan Barang', 'material/request/edit/' . $pb_id => 'Ubah Data'],
			'opened'	=> 'material',
			'head'		=> Pb::fetchDetail($pb_id),
			'sub'		=> Pbs::fetchForEditPM($pb_id)
		];

		return view('material.request.edit', $data);
	}
	public function requestUpdate(Request $req)
	{
		$rec = Pb::find($_POST['pb_id']);

		$rec->pb_no 		= trim($req->input('pb_no'));
		$rec->pb_tgl_butuh	= $req->input('pb_tgl_butuh');
		$rec->sup_id 		= $req->input('sup_id');
		$rec->pb_note		= trim($req->input('pb_note'));
		$rec->userid_edit	= $this->_user->user_id;

		$rec->save();

		#delete the sub first
		Pbs::where('pb_id', $_POST['pb_id'])->delete();

		#insert all new data
		$x = 0;
		foreach($_POST['mat_id'] as $val){
			$values = [
				'pb_id'		=> $_POST['pb_id'],
				'mat_id'	=> $val,
				'pbs_jml'	=> $_POST['pbs_jml'][$x]
			];

			Pbs::create($values);
			$x++;
		}

		Session::flash('updated', '<div class="info success">Permintaan material berhasil diubah.</div>');
		return redirect('material/request/edit/' . $_POST['pb_id']);
	}
	public function acceptance(Request $req)
	{
		$data = [
			'title'		=> 'Daftar Penerimaan Material',
			'asset'		=> new Assets(),
			'js'		=> ['vendor/jquery.dataTables.min'],
			'css'		=> ['jquery.dataTables'],
			'position'	=> ['material' => 'Material', 'material/acceptance' => 'Penerimaan'],
			'fetch'		=> Pener::fetchData(),
			'opened'	=> 'material',
			'role'		=> $this->_user->hak_akses
		];

		return view('material.acceptance.index', $data);
	}
	public function acceptanceCreate($po_id = null)
	{
		$data = [
			'title'		=> 'Tambah Penerimaan Material',
			'asset'		=> new Assets(),
			'position'	=> ['material' => 'Material', 'material/acceptance' => 'Penerimaan', 'material/acceptance/create' => 'Tambah Penerimaan'],
			'opened'	=> 'material'
		];

		if(! is_null($po_id)){
			$data += [
				'head'	=> Po::getDetail($po_id),
				'sub'	=> Po_sub::fetchDetail($po_id)
			];
		}

		return view('material.acceptance.create', $data);
	}
	public function acceptanceGetPO()
	{
		return view('material.acceptance.getPO', ['fetch' => Po::acceptanceGetPO()]);
	}
	public function acceptanceSearchPO()
	{
		$get = Po::acceptanceGetPO(trim($_POST['filter']));
		return view('material.acceptance.searchPO', ['fetch' => $get]);
	}
	public function acceptanceStore(Request $req)
	{
		$vals = [
			'po_id'			=> $_POST['po_id'],
			'pener_date'	=> now(),
			'userid_input'	=> $this->_user->user_id,
			'visibility'	=> 1
		];

		$pener = Pener::create($vals);
		foreach($_POST['pos_id'] as $pos_id){
			if(! empty($_POST['peners_jml_' . $pos_id])){
				$vals = [
					'pener_id'	=> $pener->pener_id,
					'pos_id'	=> $pos_id,
					'peners_jml'=> $_POST['peners_jml_' . $pos_id]
				];

				Peners::create($vals);

				if(! empty($_POST['mat_id_' . $pos_id])){
					$mat = MatModel::find($_POST['mat_id_' . $pos_id]);

					$mat->mat_stock_akhir = $mat->mat_stock_akhir + $_POST['peners_jml_' . $pos_id];
					$mat->save();
				}
			}
		}

		#Checking for update po_status
		$sub = Po_sub::fetchDetail($_POST['po_id']);
		$el = array();

		foreach($sub as $row){
			$diterima = countDiterima($row->pos_id);
			$rest = $row->pbs_jml - $diterima;

			if($rest > 0){
				array_push($el, 'open');
			}
		}

		if(! in_array('open', $el)){
			$rec = Po::find($_POST['po_id']);

			$rec->po_status = 2;
			$rec->save();
		}
		#End of checking

		Session::flash('inserted', '<div class="info success">Penerimaan material berhasil diinput.</div>');
		return redirect('material/acceptance');
	}
	public function acceptanceShow($po_id)
	{
		$data = [
			'head'			=> Po::getDetail($po_id),
			'fetch'			=> Pener::fetchAll($po_id),
			'Peners'		=> new Peners(),
			'Returpener'	=> new Returpener()
		];

		return view('material.acceptance.show', $data);
	}
	public function acceptanceReturContent(Request $req)
	{
		$pener_id = $req->input('penerId');
		$data = [
			'pener_id'	=> $pener_id,
			'fetch'		=> Returpeners::fetch(null, $pener_id)
		];

		return view('material.acceptance.returContent', $data);
	}

	public function acceptanceRetur(Request $request)
	{
		$perPage	= 20;
		$search 	= [
			's'		=> ($request->has('s') ? $request->input('s') : null),
			'field'	=> ($request->has('field') ? $request->input('field') : null)
		];
		$data = [
			'title'		=> 'Daftar Retur Penerimaan',
			'asset'		=> new Assets(),
			'position'	=> ['material' => 'Material', 'material/acceptance' => 'Penerimaan', 'material/acceptance/retur' => 'Retur'],
			'opened'	=> 'material',
			'role'		=> $this->_user->hak_akses,
			'fetchAppr' => Returpener::fetchApprovement($this->_user->hak_akses),
			'fetch'		=> Returpener::fetch(['search' => $search, 'perPage' => $perPage, 'role' => $this->_user->hak_akses]),
			'search'	=> $search,
			'getNumb'	=> function() use ($perPage, $request){
				if($request->has('page') && $request->input('page') != 1){
					return ($request->input('page') * $perPage) - $perPage;
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
		$data['fetch']->setPath(url('material'));
		if($request->has('s')) $data['fetch']->appends(['field' => $search['field'], 's' => $search['s']]);
		# End of pagination config

		return view('material.acceptance.retur.index', $data);
	}
	public function acceptanceReturCreate($pener_id)
	{
		$data = [
			'title'		=> 'Form Pengendalian Barang Tidak Sesuai',
			'asset'		=> new Assets(),
			'position'	=> ['material' => 'Material', 'material/acceptance' => 'Penerimaan', 'material/acceptance/retur' => 'Retur', 'material/acceptance/retur/create/'.$pener_id => 'Create'],
			'opened'	=> 'material',
			'head'		=> Pener::fetchHead($pener_id),
			'fetch'		=> Peners::fetchDetail(['B.pener_id' => $pener_id]),
			'pener_id'	=> $pener_id
		];

		return view('material.acceptance.retur.create', $data);
	}
	public function acceptanceReturStore(Request $req)
	{
		$vals = [
			'userid_input'		=> $this->_user->user_id,
			'pener_id'			=> $req->input('pener_id'),
			'returpener_status'	=> 1,
			'visibility'		=> 1,
			'created_at'		=> now(true)
		];

		$head = Returpener::create($vals);

		$x = 0;
		foreach($_POST['peners_id'] as $peners_id){
			if(! empty($_POST['jml_retur'][$x]) && $_POST['jml_retur'][$x] != '0'){
				$vals = [
					'returpener_id'			=> $head->returpener_id,
					'peners_id'				=> $peners_id,
					'returpeners_jml'		=> trim($_POST['jml_retur'][$x]),
					'returpeners_reason'	=> trim($_POST['reason'][$x]),
					'returpeners_is_reduced'=> 2
				];

				Returpeners::create($vals);
			}

			$x++;
		}

		Session::flash('message', '<div class="info success">Pengendalian Barang Tidak Sesuai berhasil dibuat, selanjutnya data akan ditampilkan di QA untuk proses approvement.</div>');
		return redirect('material/acceptance/retur');
	}
	public function acceptanceReturShow($returpener_id)
	{
		$data = [
			'head'	=> Returpener::fetchHead($returpener_id),
			'fetch'	=> Returpeners::fetch($returpener_id)
		];

		return view('material.acceptance.retur.show', $data);
	}
	public function acceptanceReturAccept($returpener_id)
	{
		$get = Returpener::find($returpener_id);

		switch($get->returpener_status){
			case 1 :
				$status = 2;
				$get->qa_approved_at = now(true);
			break;
			case 2 :
				$status = 3;
				$get->kprod_approved_at = now(true);
			break;
			case 3 :
				$status = 4;
				$get->ppic_approved_at = now(true);
			break;
			case 4 :
				$status = 5;
				$get->vd_approved_at = now(true);
			break;
		}

		$get->returpener_status = $status;
		$get->save();

		Session::flash('message', '<div class="info success">Retur penerimaan material telah di-approve.</div>');
		return redirect('material/acceptance/retur');
	}
	public function acceptForm()
	{
		return view('material.acceptance.retur.acceptForm');
	}
	public function saveVdDesc(Request $req)
	{
		$get = Returpener::find($req->input('returpener_id'));
		$get->returpener_vd_desc = trim($req->input('desc'));
		
		return $get->save();
	}
	public function acceptanceReturDestroy($returpener_id)
	{
		$get = Returpener::find($returpener_id);

		$get->visibility = 2;
		$get->save();

		Session::flash('deleted', '<span class="info warning">Data Retur Penerimaan Material telah dihapus.</span>');
		return redirect('material/acceptance/retur/');
	}
	public function acceptanceReturInput()
	{
		return 'Hello World';
	}

}
