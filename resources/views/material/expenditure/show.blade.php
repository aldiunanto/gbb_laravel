<div class="material-request-detail">
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
	<table class="data-list">
		
	</table>
</div>