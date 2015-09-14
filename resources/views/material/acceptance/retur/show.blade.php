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
			<?php $x = 0 ?>
			@foreach($fetch as $row)
			<tr>
				<td class="text-right">{{ ++$x }}.</td>
				<td>{{ $row->mat_nama }}</td>
				<td>{{ $row->mat_spesifikasi }}</td>
				<td class="text-center">{{ (empty($row->wrn_nama) ? '-' : $row->wrn_nama) }}</td>
				<td class="text-center">{{ $row->mats_nama }}</td>
				<td class="text-center">{{ $row->peners_jml }}</td>
				<td class="text-center">{{ $row->returpeners_jml }}</td>
				<td>{{ $row->returpeners_reason }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>