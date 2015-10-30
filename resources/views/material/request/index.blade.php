@extends('base')

@section('content')
<input type="hidden" name="pm" value="true" />

{!! session('accepted') !!}
@if($hak_akses != 3 && $fetchReq->count() > 0)
<div class="top approving">
	<div class="tools">&nbsp;</div>
	<h2>
		<?php $count = count_request(); echo ($count == 0 ? '' : '<span>'.$count.'</span>') ?>
		<?php echo ($hak_akses == 2 ? 'PM di-approve' : 'Persetujuan Material') ?>
	</h2>
	<div class="clearfix"></div>
</div>
<div class="main approving">
	<table class="data-list">
		<thead>
			<tr>
				<th>No</th>
				<th>Nomor Permintaan</th>
				<th>Supplier</th>
				<th>Tanggal Dibutuhkan</th>
				<th>Catatan</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			<?php $x = 0; ?>
			@foreach($fetchReq as $row)
			<tr>
				<td class="text-right">{{ ++$x }}.</td>
				<td>{{ $row->pb_no }}</td>
				<td>{{ $row->sup_nama }}</td>
				<td class="text-center">{{ to_indDate($row->pb_tgl_butuh) }}</td>
				<td>{{ $row->pb_note }}</td>
				<td class="text-right">
					<ul class="actions">
						<li><span><i class="fa fa-angle-down"></i></span>
							<ul>
								<li><a href="{{ url('material/request/show/' . $row->pb_id) }}" class="view-request-detail"><i class="fa fa-eye"></i>Lihat Detail</a></li>
								<li class="separator">&nbsp;</li>

								@if(($hak_akses == 1 || $hak_akses == 4 || $hak_akses == 5) && $row->pb_status != 3)
								<li><a href="{{ url('material/request/accept/' . $row->pb_id) }}" class="do-approve"><i class="fa fa-check"></i>Setujui</a></li>
								<li><a href="{{ url('material/request/reject/' . $row->pb_id) }}" class="do-reject"><i class="fa fa-remove"></i>Tolak</a></li>
								<li class="separator">&nbsp;</li>
								@endif

								@if($hak_akses != 2 && $hak_akses != 3)
								<li><a href="{{ url('material/request/edit/' . $row->pb_id) }}"><i class="fa fa-edit"></i>Ubah Data</a></li>
								@endif

								@if($row->pb_status == 3 && ($hak_akses == 1 || $hak_akses == 2 || $hak_akses == 3))
								<li><a href="{{ url('po/create/' . $row->pb_id) }}"><i class="fa fa-check-square-o"></i>Buat PO</a></li>
								@endif

								@if($hak_akses == 1 || $hak_akses == 2)
								<li><a href="{{ url('material/request/cancel/' . $row->pb_id) }}" class="cancel"><i class="fa fa-times-circle"></i>Batalkan</a></li>
								@endif

								@if($hak_akses == 1)
								<li><a href="{{ url('material/request/destroy/' . $row->pb_id) }}" class="delete"><i class="fa fa-trash"></i>Hapus</a></li>
								@endif
							</ul>
						</li>
					</ul>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endif

<div class="top">
	<div class="tools">
		<div class="search" <?php echo (! is_null($s) ? 'style="display: block;"' : '') ?>>
			<form action="{{ url('material/request') }}" method="get">
				<i class="fa fa-close"></i>
				<input type="text" name="s" value="{{ $s }}" placeholder="Nomor Permintaan.." />
				<button><i class="fa fa-search"></i></button>
			</form>
		</div>
		<a href="javascript:;" class="btn btn-search warning" <?php echo (! is_null($s) ? 'style="display: none;"' : '') ?>><i class="fa fa-search"></i> Pencarian</a>
		@if($hak_akses == 3 || $hak_akses == 1)
		<a href="{{ url('material/request/create') }}" class="btn default"><i class="fa fa-plus"></i> buat permintaan</a>
		@endif
	</div>
	<h2>Daftar Permintaan Material <span>{{ $fetchData->count() }} dari {{ $fetchData->total() }}</span></h2>
	<div class="clearfix"></div>
</div>
<div class="main">
	{!! session('deleted') !!}
	{!! session('inserted') !!}
	{!! session('canceled') !!}

	@if($fetchData->total() > 0)
	<table class="data-list">
		<thead>
			<tr>
				<th>No</th>
				<th>Nomor Permintaan</th>
				<th>Supplier</th>
				<th>Tanggal Dibutuhkan</th>
				<th>Status</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
		<?php $x = $getNumb(); ?>
		@foreach($fetchData as $row)
			<tr>
				<td class="text-right">{{ ++$x }}.</td>
				<td>{{ $row->pb_no }}</td>
				<td>{{ $row->sup_nama }}</td>
				<td class="text-center">{{ to_indDate($row->pb_tgl_butuh) }}</td>
				<td class="text-center">
					<?php

						switch($row->pb_status){
							case 1 :
								$d = '<span class="status wait-ppic" title="Menunggu persetujuan PPIC"><i class="fa fa-spinner fa-spin"></i><span>';
							break;
							case 2 :
								$d = '<span class="status wait-vice" title="Menunggu persetujuan Vice Director"><i class="fa fa-spinner fa-spin"></i></span>';
							break;
							case 3 :
								$d = '<span class="status vice-approve" title="PM sudah di-approve"><i class="fa fa-check"></i></span>';
							break;
							case 4 :
								$d = '<span class="status po-done" title="PO sudah dibuat"><i class="fa fa-check"></i></span>';
							break;
							case 5 : //rejected by PPIC
								$d = '<span class="status pm-reject-ppic" title="PM ditolak PPIC"><i class="fa fa-times-circle"></i></span>';
							break;
						}

						if($row->pb_role_tolak == 5){ //rejected by vice director
							$d = '<span class="status pm-reject-vice" title="PM ditolak Vice Director"><i class="fa fa-times-circle"></i></span>';
						}

						echo $d;

					?>
				</td>
				<td class="text-right">
					<ul class="actions">
						<li><span><i class="fa fa-angle-down"></i></span>
							<ul>
								<li><a href="{{ url('material/request/show/' . $row->pb_id) }}" class="view-request-detail"><i class="fa fa-eye"></i>Lihat detail</a></li>
								@if($hak_akses == 1)
								<li><a href="{{ url('material/request/edit/' . $row->pb_id) }}"><i class="fa fa-edit"></i>Ubah data</a></li>
								<li><a href="{{ url('material/request/destroy/' . $row->pb_id) }}" class="delete"><i class="fa fa-trash"></i>Hapus</a></li>
								@endif
							</ul>
						</li>
					</ul>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>

	<?php echo $fetchData->render() ?>
	@else
	<div class="info warning">Tidak ada data Permintaan Barang</div>
	@endif

	<fieldset class="label-info">
		<legend>Label Info</legend>
		<ul>
			<li><span class="status wait-ppic"><i class="fa fa-spinner fa-spin"></i></span> - Menunggu persetujuan PPIC</li>
			<li><span class="status wait-vice"><i class="fa fa-spinner fa-spin"></i></span> - Menunggu persetujuan Vice Director</li>
			<li><span class="status vice-approve"><i class="fa fa-check"></i></span> - PM(Permintan Material) sudah di-approve Vice Director</li>
			<li><span class="status po-done"><i class="fa fa-check"></i></span> - PO sudah dibuat</li>
			<li><span class="status pm-reject-ppic"><i class="fa fa-times-circle"></i></span> - PM ditolak PPIC</li>
			<li><span class="status pm-reject-vice"><i class="fa fa-times-circle"></i></span> - PM ditolak Vice Director</li>
		</ul>
	</fieldset>
</div>
@endsection