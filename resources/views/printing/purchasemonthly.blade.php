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
				<td>{{ $row->sup_nama }}</td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		@endforeach
		</tbody>
	</table>
</section>

@endsection