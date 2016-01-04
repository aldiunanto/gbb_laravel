@extends('base')
@section('content')
<div class="top">
	<div class="tools">
		<div class="search" <?php echo (! is_null($search['s']) ? 'style="display: block;"' : '') ?>>
			<form action="{{ url('material/expenditure') }}" method="get">
				<i class="fa fa-close"></i>
				<select name="field">
					<option value="deptbg_nama" <?php echo $isSelected('deptbg_nama') ?>>Departemen</option>
					<option value="pengel_date" <?php echo $isSelected('pengel_date') ?>>Tanggal</option>
					<option value="pengel_bpb" <?php echo $isSelected('pengel_bpb') ?>>Nomor BPB</option>
					<option value="pengel_po" <?php echo $isSelected('pengel_po') ?>>Nomor PO</option>
				</select>
				<input type="text" name="s" value="{{ $search['s'] }}" placeholder="Kata pencarian.." />
				<button><i class="fa fa-search"></i></button>
			</form>
		</div>
		<a href="javascript:;" class="btn btn-search warning" <?php echo (! is_null($search['s']) ? 'style="display: none;"' : '') ?>><i class="fa fa-search"></i> Pencarian</a>
		<a href="{{ url('material/expenditure/create') }}" class="btn default"><i class="fa fa-plus"></i> buat pengeluaran</a>
	</div>
	<h2>Daftar Pengeluaran Material <span>0 dari 1</span></h2>
	<div class="clearfix"></div>
</div>
<div class="main">
	{!! session('deleted') !!}
	{!! session('inserted') !!}
	<table class="data-list">
		<thead>
			<tr>
				<th>No</th>
				<th>Departemen</th>
				<th>Tanggal</th>
				<th>Nomor BPB</th>
				<th>Nomor PO</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
		<?php $x = 0 ?>
		@foreach($fetch as $row)
			<tr>
				<td class="text-right">{{ ++$x }}.</td>
				<td>{{ $row->deptbg_nama }}</td>
				<td class="text-center">{{ to_indDate($row->pengel_date) }}</td>
				<td>{{ $row->pengel_bpb }}</td>
				<td>{{ $row->pengel_po }}</td>
				<td class="text-right">
					<ul class="actions">
						<li><span><i class="fa fa-angle-down"></i></span>
							<ul>
								<li><a href="{{ url('material/expenditure/show/' . $row->pengel_id) }}" class="view-detail"><i class="fa fa-eye"></i>Lihat detail</a></li>
								@if($role == 1)
								<li><a href="{{ url('material/expenditure/destroy/' . $row->pengel_id) }}" class="delete"><i class="fa fa-trash"></i>Hapus</a></li>
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
@endsection