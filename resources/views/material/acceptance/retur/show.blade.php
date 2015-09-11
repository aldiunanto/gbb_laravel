<div class="acceptance-retur-detail">
	<div class="base-info">
		<table>
			<tr>
				<td class="field">Tanggal Diketahui</td>
				<td class="colon">:</td>
				<td>{{ $head->created_at }}</td>
				<td class="field">Tanggal Penerimaan</td>
				<td class="colon">:</td>
				<td>{{ $head->pener_date }}</td>
			</tr>
			<tr>
				<td class="field">Nomor PO</td>
				<td class="colon">:</td>
				<td>{{ $head->po_no }}</td>
				<td class="field">Supplier</td>
				<td class="colon">:</td>
				<td>{{ $head->sup_nama }}</td>
			</tr>
		</table>
	</div>
	<!-- <table class="data-list">
		<thead>
			<tr>
				<th>No</th>
				<th>Material</th>
				<th>Spesifikasi</th>
				<th>Satuan</th>
				<th>Jumlah</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table> -->
</div>