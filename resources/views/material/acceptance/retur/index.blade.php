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
				<td class="text-center">{{ $row->pener_date }}</td>
				<td class="text-center">{{ $row->created_at }}</td>
				<td class="text-right">
					<ul class="actions">
						<li><span><i class="fa fa-angle-down"></i></span>
							<ul>
								<li><a href="" class="view-retur-detail"><i class="fa fa-eye"></i>Lihat Detail</a></li>
								<li class="separator">&nbsp;</li>

								<li><a href="" class="do-approve"><i class="fa fa-check"></i>Setujui</a></li>
								<li><a href="" class="do-reject"><i class="fa fa-remove"></i>Tolak</a></li>
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