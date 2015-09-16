@extends('base')

@section('content')

@if($role != 3 && $fetchAppr->count() > 0)
<div class="top approving">
	<div class="tools">&nbsp;</div>
	<h2>
		<?php $count = count_returApprovement(); echo ($count == 0 ? '' : '<span>'.$count.'</span>') ?>
		<?php echo ($role == 2 ? 'Retur Penerimaan di-approve' : 'Persetujuan Retur Penerimaan') ?>
	</h2>
	<div class="clearfix"></div>
</div>
<div class="main approving">	
	{!! session('message') !!}
	<table class="data-list">
		<thead>
			<tr>
				<th>No</th>
				<th>Nomor PO</th>
				<th>Supplier</th>
				<th>Tanggal Penerimaan</th>
				<th>Tanggal Diketahui</th>
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
								<li><a href="{{ url('printing/do/' . $row->returpener_id) }}" target="_blank" ><i class="fa fa-print"></i>Cetak Surat Jalan</a></li>
								@else
								<li><a href="{{ url('material/acceptance/retur/accept/' . $row->returpener_id) }}" class="do-approve{{ ($role == 5 ? ' vd' : '') }}"><i class="fa fa-check"></i>Setujui</a></li>
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

@endsection