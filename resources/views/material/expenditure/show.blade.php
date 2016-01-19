<div class="acceptance-retur-detail">
	<div class="base-info">
		<table>
			<tr>
				<td class="field">Departemen</td>
				<td class="colon">:</td>
				<td>{{ $head->deptbg_nama }}</td>
				<td class="field">Nomor PO</td>
				<td class="colon">:</td>
				<td>{{ $head->pengel_po }}</td>
			</tr>
			<tr>
				<td class="field">Nomor BPB</td>
				<td class="colon">:</td>
				<td>{{ $head->pengel_bpb }}</td>
				<td class="field">Tanggal</td>
				<td class="colon">:</td>
				<td>{{ to_indDate($head->pengel_date) }}</td>
			</tr>
		</table>
	</div>
	<span class="info warning text-center"><i>*Satuan yang digunakan adalah satuan <strong>Gudang</strong>.</i></span>
	<div class="list">
		<table class="data-list">
			<thead>
				<tr>
					<th rowspan="2">No.</th>
					<th rowspan="2">Material</th>
					<th rowspan="2">Warna</th>
					<th rowspan="2">Spesifikasi</th>
					<th rowspan="2">Satuan</th>
					<th colspan="2">Jumlah</th>
					<th rowspan="2">Ket</th>
				</tr>
				<tr>
					<th>Permintaan</th>
					<th>Realisasi</th>
				</tr>
			</thead>
			<tbody>
			<?php $x = 0 ?>
			@foreach($sub as $row)
				<tr>
					<td class="text-right">{{ ++$x }}.</td>
					<td>{{ $row->mat_nama }}</td>
					<td class="text-center">{{ $row->wrn_nama }}</td>
					<td>{{ $row->mat_spesifikasi }}</td>
					<td class="text-center">{{ $row->mats_nama }}</td>
					<td class="text-right">{{ number_format($row->pengels_permintaan, 2, ',', '.') }}</td>
					<td class="text-right">{{ number_format($row->pengels_realisasi, 2, ',', '.') }}</td>
					<td class="text-center">{{ $row->pengels_ket }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
</div>
