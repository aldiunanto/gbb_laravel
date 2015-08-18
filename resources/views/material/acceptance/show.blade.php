<div class="acceptance-detail">
	<div class="base-info">
		<table>
			<tr>
				<td class="field">Nomor PO</td>
				<td class="colon">:</td>
				<td>{{ $head->po_no }}</td>
			</tr>
			<tr>
				<td class="field">Supplier</td>
				<td class="colon">:</td>
				<td>{{ $head->sup_nama }}</td>
			</tr>
			<tr>
				<td class="field">Tanggal Dibutuhkan</td>
				<td class="colon">:</td>
				<td>{{ to_indDate($head->po_tgl_kedatangan) }}</td>
			</tr>
		</table>
	</div>
	<table class="data-list">
		<thead>
			<td>
				<th>Material</th>
				<th>Spesifikasi</th>
				<th>Diterima</th>
				<th>Satuan</th>
			</td>
		</thead>
	</table>
</div>