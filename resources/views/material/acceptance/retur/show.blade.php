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
				<th>Dikirim</th>
				<th>Jml Retur</th>
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
				<td class="text-center">{{ $row->satuanP }}</td>
				<td class="text-center">{{ $row->peners_jml }}</td>
				<td class="text-center">
					@if($row->satuanP != $row->satuanR)
						{{ $row->returpeners_jml . ' ' . $row->satuanP . ' (atau) ' . (round($row->returpeners_jml * $row->mat_perbandingan)) . ' ' . $row->satuanR }}
					@else
						{{ $row->returpeners_jml }}
					@endif
				</td>
			</tr>
			@endforeach
			<tr>
				<td colspan="7" class="text-center">
					<em>Alasan: {{ ($head->returpener_reason ?: '-') }}</em>
				</td>
			</tr>
			@if($head->returpener_note)
			<tr>
				<td colspan="7">
					<p>
						Catatan:<br />
						{!! $head->returpener_note !!}
					</p>
				</td>
			</tr>
			@endif
		</tbody>
	</table>
</div>