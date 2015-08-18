@extends('base')

@section('content')
<div class="top">
	<div class="tools">
		<a href="{{ url('material/acceptance/create') }}" class="btn default"><i class="fa fa-plus"></i> tambah penerimaan</a>
	</div>
	<h2>Daftar Penerimaan Material <span>{{ $fetch->count() }} dari {{ $fetch->total() }}</span></h2>
	<div class="clearfix"></div>
</div>
<div class="main">
	{!! session('deleted') !!}
	{!! session('inserted') !!}
	<table class="data-list index">
		<thead>
			<tr>
				<th>No</th>
				<th>Nomor PO</th>
				<th>Tanggal Permintaan</th>
				<th>Tanggal Penerimaan</th>
				<th>Keterangan</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
		<?php $x = $getNumb(); ?>
		@foreach($fetch as $row)

			<tr>
				<td class="text-right">{{ ++$x }}.</td>
				<td>{{ $row->po_no }}</td>
				<td class="text-center">{{ to_indDate($row->po_tgl_kedatangan) }}</td>
				<td class="text-center">{{ to_indDate($row->pener_date) }}</td>
				<td class="text-center"><?php echo dateDiff($row->po_tgl_kedatangan, $row->pener_date) ?></td>
				<td class="text-right">
					<ul class="actions">
						<li><span><i class="fa fa-angle-down"></i></span>
							<ul>
								<li><a href="{{ url('material/acceptance/show/' . $row->po_id) }}" class="view-detail"><i class="fa fa-eye"></i>Lihat detail</a></li>
							</ul>
						</li>
					</ul>
				</td>
			</tr>

		@endforeach
		</tbody>
	</table>

	<?php echo $fetch->render() ?>
</div>
@endsection