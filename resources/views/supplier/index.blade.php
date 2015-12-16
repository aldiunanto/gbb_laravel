@extends('base')

@section('content')
<div class="top">
	<div class="tools">
		<div class="search" <?php echo (! is_null($search) ? 'style="display: block;"' : '') ?>>
			<form action="{{ url('supplier') }}" method="get">
				<i class="fa fa-close"></i><input type="text" name="s" value="{{ $search }}" placeholder="Nama Supplier" />
				<button><i class="fa fa-search"></i></button>
			</form>
		</div>
		<a href="javascript:;" class="btn-search btn warning" <?php echo (! is_null($search) ? 'style="display: none;"' : '') ?>><i class="fa fa-search"></i> Pencarian</a>
		@if($role != 4 && $role != 5 && $role != 6 && $role != 7)
		<a href="{{ url('supplier/create') }}" class="btn default"><i class="fa fa-plus"></i> tambah supplier baru</a>
		@endif
		<div class="clearfix"></div>
	</div>
	<h2>Supplier List <span>({{ $fetch->count() }} dari {{ $fetch->total() }})</span></h2>
	<div class="clearfix"></div>
</div>
<div class="main">
	{!! session('deleted') !!}
	{!! session('inserted') !!}
	<table class="data-list">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Supplier</th>
				@if(! in_array($role, $banned))
				<th>No. Telepon</th>
				<th>Kota</th>
				@endif
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
		<?php $x = $getNumb(); ?>
		@foreach($fetch as $row)
		
			<tr>
				<td class="text-right">{{ ++$x }}.</td>
				<td>{{ $row->sup_nama }}</td>
				@if(! in_array($role, $banned))
				<td>{{ $row->sup_telepon }}</td>
				<td>{{ $row->sup_kota }}</td>
				@endif
				<td class="text-right">
					<ul class="actions">
						<li><span><i class="fa fa-angle-down"></i></span>
							<ul>
								<li><a href="{{ url('supplier/show/' . $row->sup_id) }}" class="view-detail {{ (in_array($role, $banned) ? 'no-print' : '') }}"><i class="fa fa-eye"></i>Lihat detail</a></li>
								@if(! in_array($role, $banned))
								<li><a href="{{ url('supplier/edit/' . $row->sup_id) }}"><i class="fa fa-edit"></i>Ubah data</a></li>
								<li><a href="{{ url('material/edit/' . $row->sup_id . '/price') }}" title="Ubah semua harga material untuk supplier {{ $row->sup_nama }}"><i class="fa fa-money"></i>Ubah harga</a></li>
								<li><a href="{{ url('supplier/destroy/' . $row->sup_id) }}" class="delete"><i class="fa fa-trash"></i>Hapus</a></li>
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