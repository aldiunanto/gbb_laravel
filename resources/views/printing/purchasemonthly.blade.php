@extends('printing')
@section('content')

<header>
	<div class="caption">
		<h1>pt jaly indonesia utama</h1>
		<h2>laporan pembelian bahan baku</h2>
		<h2>{{ $period }}</h2>
	</div>
</header>
<section>
	<h3>Bahan Baku PPN</h3>
	<table class="data-list">
		<thead>
			<tr>
				<th>Tanggal</th>
				<th>Supplier</th>
				<th>Nama Barang</th>
				<th>QTY</th>
				<th>Unit</th>
			</tr>
		</thead>
		<tbody>
		@foreach($fetchp as $row)
			<tr>
				<td>{{ to_indDate($row->pener_date) }}</td>
				<td class="left">{{ $row->sup_nama }}</td>

			<?php $x = 1 ?>
			@foreach($Peners::purchasemonthly($row->pener_id) as $sub)
				@if($x > 1)
				<tr>
					<td></td>
					<td></td>
				@endif

					<td class="left">{{ $sub->mat_nama }}</td>
					<td class="right">{{ $sub->peners_jml }}</td>
					<td>{{ $sub->mats_nama }}</td>
				</tr>

				<?php $x++ ?>
			@endforeach
		@endforeach
		</tbody>
	</table>
</section>

@endsection