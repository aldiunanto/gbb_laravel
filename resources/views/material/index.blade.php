@extends('base')

@section('content')
<div class="top">
	<div class="tools">
		<div class="search" <?php echo (! is_null($search['s']) ? 'style="display: block;"' : '') ?>>
			<form action="{{ url('material') }}" method="get">
				<i class="fa fa-close"></i>
				<select name="field">
					<option value="mat_nama" <?php echo $isSelected('mat_nama') ?>>Nama material</option>
					<option value="sup_nama" <?php echo $isSelected('sup_nama') ?>>Nama supplier</option>
				</select>
				<input type="text" name="s" value="{{ $search['s'] }}" placeholder="Kata pencarian.." />
				<button><i class="fa fa-search"></i></button>
			</form>
		</div>
		<a href="javascript:;" class="btn btn-search warning" <?php echo (! is_null($search['s']) ? 'style="display: none;"' : '') ?>><i class="fa fa-search"></i> Pencarian</a>
		@if($role != 4 && $role != 5 && $role != 6 && $role != 7)
		<a href="{{ url('material/create') }}" class="btn default"><i class="fa fa-plus"></i> tambah material baru</a>
		@endif
	</div>
	<h2>Material List <span>{{ $fetch->count() }} dari {{ $fetch->total() }}</span></h2>
	<div class="clearfix"></div>
</div>
<div class="main">
	{!! session('deleted') !!}
	{!! session('inserted') !!}
	<table class="data-list">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Material</th>
				<th>Spesifikasi</th>
				@if($role != 3 && $role != 4 && $role != 6 && $role != 7)
				<th>Satuan</th>
				@endif
				<th>Bagian</th>
				<th>Supplier</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
		<?php $x = $getNumb(); ?>
		@foreach($fetch as $row)

			<tr <?php echo (($row->mat_stock_akhir <= $row->mat_stock_min) || $row->mat_stock_min == 0 ? 'class="danger"' : '') ?>>
				<td class="text-right">{{ ++$x }}.</td>
				<td>{{ $row->mat_nama }}</td>
				<td>{{ $row->mat_spesifikasi }}</td>
				@if($role != 3 && $role != 4 && $role != 6 && $role != 7)
				<td>{{ $row->mats_nama }}</td>
				@endif
				<td>{{ $row->deptbg_nama }}</td>
				<td>{{ $row->sup_nama }}</td>
				<td class="text-right">
					<ul class="actions">
						<li><span><i class="fa fa-angle-down"></i></span>
							<ul>
								<li><a href="{{ url('material/show/' . $row->mat_id) }}" class="view-detail {{ (in_array($role, [1,2,3])) ? '' : 'no-print' }}"><i class="fa fa-eye"></i>Lihat detail</a></li>

								@if($role != 4 && $role != 5 && $role != 6 && $role != 7)
								<li><a href="{{ url('material/edit/' . $row->mat_id) }}"><i class="fa fa-edit"></i>Ubah data</a></li>
								@endif

								@if($role == 1 || $role == 2)
								<li><a href="{{ url('material/edit/' . $row->sup_id . '/price') }}" title="Ubah semua harga material untuk supplier {{ $row->sup_nama }}"><i class="fa fa-money"></i>Ubah harga</a></li>
								@endif

								@if($role != 3 && $role != 4 && $role != 6 && $role != 7)
								<li><a href="{{ url('material/destroy/' . $row->mat_id) }}" class="delete"><i class="fa fa-trash"></i>Hapus</a></li>
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
</div>
@endsection