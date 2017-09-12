@extends('base')

@section('content')

{!! session('message') !!}
@if(($role != 3 && $role != 6) && $fetchAppr->count() > 0)
<div class="top approving">
	<div class="tools">&nbsp;</div>
	<h2>
		<?php $count = count_returApprovement(); echo ($count == 0 ? '' : '<span>'.$count.'</span>') ?>
		<?php echo ($role == 2 ? 'Retur Penerimaan di-approve' : 'Persetujuan Retur Penerimaan') ?>
	</h2>
	<div class="clearfix"></div>
</div>
<div class="main approving">
	<table class="data-list">
		<thead>
			<tr>
				<th>No</th>
				<th>Nomor PO</th>
				<th>Supplier</th>
				<th>Tanggal Penerimaan</th>
				<th>Tanggal Retur</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			<?php $x = 0 ?>
			@foreach($fetchAppr as $row)
			<tr>
				<td class="text-right">{{ ++$x }}.</td>
				<td>{{ $row->po_no }}</td>
				<td>{{ $row->sup_nama }}</td>
				<td class="text-center">{{ to_indDate($row->pener_date) }}</td>
				<td class="text-center"><?php $diket = explode(' ', $row->created_at); echo to_indDate($diket[0]); ?></td>
				<td class="text-right">
					<ul class="actions">
						<li><span><i class="fa fa-angle-down"></i></span>
							<ul>
								<li><a href="{{ url('material/acceptance/retur/show/' . $row->returpener_id) }}" class="view-retur-detail"><i class="fa fa-eye"></i>Lihat Detail</a></li>
								<li class="separator">&nbsp;</li>

								@if(($role == 2 || $role == 1) && $row->returpener_status == 5)
								<li><a href="{{ url('printing/do/' . $row->returpener_id) }}" class="deliv-order" ><i class="fa fa-print"></i>Cetak Surat Jalan</a></li>
								@else
								<li><a href="{{ url('material/acceptance/retur/accept/' . $row->returpener_id) }}" class="do-approve{{ (($row->returpener_status == 4) ? ' vd' : '') }}"><i class="fa fa-check"></i>Setujui</a></li>
								<li><a href="{{ url('material/acceptance/retur/reject/' . $row->returpener_id) }}" class="do-reject"><i class="fa fa-remove"></i>Tolak</a></li>
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
		<div class="search" <?php echo (! is_null($search['s']) ? 'style="display: block;"' : '') ?>>
			<form action="{{ url('material/acceptance/retur') }}" method="get">
				<i class="fa fa-close"></i>
				<select name="field">
					<option value="po_no" <?php echo $isSelected('po_no') ?>>Nomor PO</option>
					<option value="sup_nama" <?php echo $isSelected('sup_nama') ?>>Supplier</option>
				</select>
				<input type="text" name="s" value="{{ $search['s'] }}" placeholder="Kata pencarian.." />
				<button><i class="fa fa-search"></i></button>
			</form>
		</div>
		<a href="javascript:;" class="btn btn-search warning" <?php echo (! is_null($search['s']) ? 'style="display: none;"' : '') ?>><i class="fa fa-search"></i> Pencarian</a>
	</div>
	<h2>Daftar Retur Penerimaan Material <span>{{ $fetch->count() . ' dari ' . $fetch->total() }}</span></h2>
	<div class="clearfix"></div>
</div>
<div class="main">
	{!! session('deleted') !!}
	{!! session('inserted') !!}
	<table class="data-list">
		<thead>
			<tr>
				<th>No</th>
				<th>Nomor PO</th>
				<th>Supplier</th>
				<th>Tgl Penerimaan</th>
				<th>Tgl Retur</th>
				<th>Status</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
		<?php $x = $getNumb(); ?>
		@foreach($fetch as $row)

			<tr>
				<td class="text-right">{{ ++$x }}.</td>
				<td>{{ $row->po_no }}</td>
				<td>{{ $row->sup_nama }}</td>
				<td class="text-center">{{ to_indDate($row->pener_date) }}</td>
				<td class="text-center"><?php $diket = explode(' ', $row->created_at); echo to_indDate($diket[0]); ?></td>
				<td class="text-center">
					<?php
						switch($row->returpener_status){
							case 1: echo '<span class="status wait-ppic" title="Menunggu persetujuan QA"><i class="fa fa-spinner fa-spin"></i></span>';  break;
							case 2: echo '<span class="status wait-kabag" title="Menunggu persetujuan Kabag. Raw Material"><i class="fa fa-spinner fa-spin"></i></span>'; break;
							case 3: echo '<span class="status wait-ppic2" title="Menunggu persetujuan PPIC"><i class="fa fa-spinner fa-spin"></i></span>'; break;
							case 4: echo '<span class="status wait-vd" title="Menunggu persetujuan Vice Director"><i class="fa fa-spinner fa-spin"></i></span>'; break;
							case 5: echo '<span class="status vice-approve" title="Sudah di-approve Vice Director"><i class="fa fa-check"></i></span>'; break;
							case 6: echo '<span class="status po-done" title="Sudah dibuat Surat Jalan"><i class="fa fa-check"></i></span>'; break;
							case 7: echo '<span class="status retur-reject-qa" title="Ditolak QA"><i class="fa fa-times"></i></span>'; break;
							case 8: echo '<span class="status retur-reject-kabag" title="Ditolak Kabag. Raw Material"><i class="fa fa-times"></i></span>'; break;
							case 9: echo '<span class="status retur-reject-ppic" title="Ditolak PPIC"><i class="fa fa-times"></i></span>'; break;
							case 10: echo '<span class="status pm-reject-vice" title="Ditolak Vice Director"><i class="fa fa-times"></i></span>'; break;
						}
					?>
				</td>
				<td class="text-right">
					<ul class="actions">
						<li><span><i class="fa fa-angle-down"></i></span>
							<ul>
								<li><a href="{{ url('material/acceptance/retur/show/' . $row->returpener_id) }}" class="view-retur-detail"><i class="fa fa-eye"></i>Lihat Detail</a></li>

								@if($row->returpener_status == 6 && ($role == 1 || $role == 2))
								<li><a href="{{ url('printing/do/' . $row->returpener_id) }}" target="_blank" ><i class="fa fa-print"></i>Cetak Surat Jalan</a></li>
								@endif

								@if($role == 1 || $role == 5)
								<li class="separator">&nbsp;</li>
								<li><a href="{{ url('material/acceptance/retur/destroy/' . $row->returpener_id) }}" class="delete"><i class="fa fa-trash"></i>Hapus</a></li>
								@endif
							</ul>
						</li>
					</ul>
				</td>
			</tr>

		@endforeach
		</tbody>
	</table>

	<?php echo $fetch->render() ?>

	<fieldset class="label-info">
		<legend>Label Info</legend>
		<ul>
			<li><span class="status wait-ppic"><i class="fa fa-spinner fa-spin"></i></span> - Menunggu persetujuan QA</li>
			<li><span class="status wait-kabag"><i class="fa fa-spinner fa-spin"></i></span> - Menunggu persetujuan Kabag. Raw Material</li>
			<li><span class="status wait-ppic2"><i class="fa fa-spinner fa-spin"></i></span> - Menunggu persetujuan PPIC</li>
			<li><span class="status wait-vd"><i class="fa fa-spinner fa-spin"></i></span> - Menunggu persetujuan Vice Director</li>
			<li><span class="status vice-approve"><i class="fa fa-check"></i></span> - Sudah di-approve Vice Director</li>
			<li><span class="status po-done"><i class="fa fa-check"></i></span> - Sudah dibuat Surat Jalan</li>
			<li><span class="status retur-reject-qa"><i class="fa fa-times"></i></span> - Ditolak QA</li>
			<li><span class="status retur-reject-kabag"><i class="fa fa-times"></i></span> - Ditolak Kabag. Raw Material</li>
			<li><span class="status retur-reject-ppic"><i class="fa fa-times"></i></span> - Ditolak PPIC</li>
			<li><span class="status pm-reject-vice"><i class="fa fa-times"></i></span> - Ditolak Vice Director</li>
		</ul>
	</fieldset>
</div>

@endsection