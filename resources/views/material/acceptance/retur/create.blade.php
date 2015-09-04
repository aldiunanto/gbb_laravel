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
			<table>
				<tr>
					<td>Nomor PO</td>
					<td>:</td>
					<td><strong>NP/002/VII/JIU/2015</strong></td>
				</tr>
				<tr>
					<td>Supplier</td>
					<td>:</td>
					<td>Aldi Unanto</td>
				</tr>
				<tr>
					<td>Tanggal Penerimaan</td>
					<td>:</td>
					<td>22-08-2015 21:21:22</td>
				</tr>
			</table>
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