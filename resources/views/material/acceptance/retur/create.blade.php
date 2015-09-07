@extends('base')

@section('content')
<div class="top">
	<div class="tools">&nbsp;</div>
	<h2>Form Retur Penerimaan</h2>
	<div class="clearfix"></div>
</div>
<div class="main">
	<div class="form">
		<div class="base-info">
			<fieldset>
				<legend><h4>Informasi PO</h4></legend>
				<table>
					<tr>
						<td>Nomor PO</td>
						<td>:</td>
						<td><strong>{{ $head->po_no }}</strong></td>
					</tr>
					<tr>
						<td>Supplier</td>
						<td>:</td>
						<td>{{ $head->sup_nama }}</td>
					</tr>
					<tr>
						<td>Tanggal Penerimaan</td>
						<td>:</td>
						<td>{{ $head->pener_date }}</td>
					</tr>
					<tr>
						<td>Tanggal Input</td>
						<td>:</td>
						<td>{{ $head->created_at }}</td>
					</tr>
				</table>
			</fieldset>
		</div>
		<div class="caption">
			<h3>Material</h3>
		</div>
		<table class="data-list">
			<thead>
				<tr>
					<th>No</th>
					<th>Material</th>
					<th>Spesifikasi</th>
					<th>Warna</th>
					<th>Satuan</th>
					<th>Diterima</th>
					<th>Jml Retur</th>
					<th>Alasan</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="text-right">1.</td>
					<td>Spidol</td>
					<td>Size M</td>
					<td class="text-center">Putih</td>
					<td class="text-center">Pcs</td>
					<td class="text-right">300</td>
					<td class="text-center jml_retur"><input type="text" name="jml_retur[]" /></td>
					<td class="text-center reason"><textarea name="reason[]"></textarea></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

@endsection