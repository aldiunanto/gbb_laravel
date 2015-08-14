@extends('base')

@section('content')
<div class="top">
	<div class="tools">
		<div class="search" <?php echo (! is_null($search['s']) ? 'style="display: block;"' : '') ?>>
			<form action="{{ url('material/acceptance') }}" method="get">
				<i class="fa fa-close"></i>
				<select name="field">
					<option value="po_no" <?php echo $isSelected('po_no') ?>>Nomor PO</option>
					<option value="po_tgl_kedatangan" <?php echo $isSelected('po_tgl_kedatangan') ?>>Tanggal Permintaan</option>
					<option value="pener_date" <?php echo $isSelected('pener_date') ?>>Tanggal Penerimaan</option>
				</select>
				<input type="text" name="s" value="{{ $search['s'] }}" placeholder="Kata pencarian.." />
				<button><i class="fa fa-search"></i></button>
			</form>
		</div>
		<a href="javascript:;" class="btn btn-search warning" <?php echo (! is_null($search['s']) ? 'style="display: none;"' : '') ?>><i class="fa fa-search"></i> Pencarian</a>
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
				<td class="text-center">{{ $row->po_tgl_kedatangan }}</td>
				<td class="text-center">{{ $row->pener_date }}</td>
				<td class="text-center"><?php echo dateDiff($row->po_tgl_kedatangan, $row->pener_date) ?></td>
				<td class="text-right">
					<ul class="actions">
						<li><span><i class="fa fa-angle-down"></i></span>
							<ul>
								<li><a href="{{ url('material/acceptance/show/' . $row->pener_id) }}" class="view-detail"><i class="fa fa-eye"></i>Lihat detail</a></li>
								<li><a href="{{ url('material/acceptance/destroy/' . $row->pener_id) }}" class="delete"><i class="fa fa-trash"></i>Hapus</a></li>
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