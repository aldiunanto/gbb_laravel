@extends('base')
@section('content')

{!! session('accepted') !!}
@if(in_array($role, [1,2,8]) && $fetchAppr->count() > 0)
<div class="top approving">
	<div class="tools">&nbsp;</div>
	<h2>
		<?php $count = countApprMaterials() ?>
		<span>{{ $count }}</span>{{ ($role == 2 ? 'Menunggu Persetujuan Kabag. Raw Material' : 'Persetujuan Material Baru') }}
	</h2>
	<div class="clearfix"></div>
</div>
<div class="main approving">
	<table class="data-list">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Material</th>
				<th>Spesifikasi</th>
				<th>Satuan</th>
				<th>Warna</th>
				<th>Supplier</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			<?php $x = 0; ?>
			@foreach($fetchAppr as $row)
			<tr>
				<td class="text-right">{{ ++$x }}.</td>
				<td>{{ $row->mat_nama }}</td>
				<td>{{ $row->mat_spesifikasi }}</td>
				<td>{{ $row->mats_nama }}</td>
				<td>{{ $row->wrn_nama  }}</td>
				<td>{{ $row->sup_nama }}</td>
				<td class="text-right">
					<ul class="actions">
						<li><span><i class="fa fa-angle-down"></i></span>
							<ul>
								<li><a href="{{ url('material/show/' . $row->mat_id) }}" class="view-detail no-print"><i class="fa fa-eye"></i>Lihat detail</a></li>
								<li class="separator">&nbsp;</li>

								@if($role != 2)
								<li><a href="{{ url('material/accept/' . $row->mat_id) }}" class="approve"><i class="fa fa-check"></i>Setujui</a></li>
								<li><a href="{{ url('material/destroy/' . $row->mat_id) }}" class="delete"><i class="fa fa-trash"></i>Batalkan</a></li>
								<li class="separator">&nbsp;</li>
								@endif
	
								<li><a href="{{ url('material/edit/' . $row->mat_id) }}"><i class="fa fa-edit"></i>Ubah data</a></li>
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
	{!! session('activeMsg') !!}

	<div class="info warning">
		*<i>Material bertanda merah menandakan bahwa:</i>
		<ul>
			<li><i>Belum memiliki Stok Minimal. ATAU</i></li>
			<li><i>Stock Akhir yang dimiliki <strong>kurang dari</strong> Stok Minimal.</i></li>
		</ul>
	</div>
	<table class="data-list">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Material</th>
				<th>Spesifikasi</th>
				@if(! in_array($role, [3,4,6,7,8]))
				<th>Satuan</th>
				@endif
				<th>Warna</th>
				<th>Supplier</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
		<?php $x = $getNumb(); ?>
		@foreach($fetch as $row)

			<?php

				$class = '';
				
				if(($row->mat_stock_akhir <= $row->mat_stock_min) || $row->mat_stock_min == 0){
					$class = 'danger';
				}
				if($row->mat_is_active == 2){
					$class = 'inactive';
				}

			?>
			<tr class="{{ $class }}">
				<td class="text-right">{{ ++$x }}.</td>
				<td>{{ $row->mat_nama }}</td>
				<td>{{ $row->mat_spesifikasi }}</td>

				@if(! in_array($role, [3,4,6,7,8]))
				<td>{{ $row->mats_nama }}</td>
				@endif
				
				@if($role == 4 || $role == 1)
				<!-- <td><a href="{{ url('material/formModifyDept/' . $row->mat_id) }}" class="modify-dept">{{ $row->deptbg_nama }}</a></td> -->
				@else
				<!-- <td>{{ $row->deptbg_nama }}</td> -->
				@endif

				<td>{{ $row->wrn_nama  }}<!--{{ ($row->mat_stock_akhir == 0 ? '-' : number_format($row->mat_stock_akhir, 2, ',', '.')) }} --></td>

				<td>{{ $row->sup_nama }}</td>
				<td class="text-right">
					<ul class="actions">
						<li><span><i class="fa fa-angle-down"></i></span>
							<ul>
								<li><a href="{{ url('material/show/' . $row->mat_id) }}" class="view-detail {{ (in_array($role, [1,2,3,8])) ? '' : 'no-print' }}"><i class="fa fa-eye"></i>Lihat detail</a></li>

								@if(! in_array($role, [2,4,5,6,7]))
								<li><a href="{{ url('material/edit/' . $row->mat_id) }}"><i class="fa fa-edit"></i>Ubah data {{ $role }}</a></li>
								@endif

								@if($role == 1 || $role == 2)
								<li><a href="{{ url('material/edit/' . $row->sup_id . '/price') }}" title="Ubah semua harga material untuk supplier {{ $row->sup_nama }}"><i class="fa fa-money"></i>Ubah harga</a></li>
								@endif

								<li><a href="{{ url('material/card-stock/' . $row->mat_id) }}" class="card-stock"><i class="fa fa-tasks"></i>Kartu Stok</a></li>

								@if($role == 1 || $role == 8)
								<li class="separator"></li>
									@if($row->mat_is_active == 2)
									<li><a href="{{ url('material/activate/' . $row->mat_id) }}" class="activate" title="Tandai sebagai material aktif"><i class="fa fa-check"></i>Aktifkan</a></li>
									@elseif($row->mat_is_active == 1)
									<li><a href="{{ url('material/deactivate/' . $row->mat_id) }}" class="deactivate" title="Tandai sebagai material tidak aktif"><i class="fa fa-remove"></i>Nonaktifkan</a></li>
									@endif
								@endif

								@if(! in_array($role, [3,4,6,7,8]))
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