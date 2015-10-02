<div class="material-request-detail">
	<div class="base-info">
		<table>
			<tr>
				<td class="field">Nomor PO</td>
				<td class="colon">:</td>
				<td>{{ $head->po_no }}</td>
				<td class="field">Tgl Penerimaan</td>
				<td class="colon">:</td>
				<td>{{ to_indDate($head->pener_date) }}</td>
			</tr>
			<tr>
				<td class="field">No. Surat Jalan</td>
				<td class="colon">:</td>
				<td>{{ $head->dorp_no }}</td>
				<td class="field">Tgl Diketahui</td>
				<td class="colon">:</td>
				<td>
					<?php
						$date = explode(' ', $head->created_at);
						echo to_indDate($date[0]);
					?>
				</td>
			</tr>
			<tr>
				<td class="field">Supplier</td>
				<td class="colon">:</td>
				<td>{{ $head->sup_nama }}</td>
				<td class="field">Tgl Kedatangan</td>
				<td class="colon">:</td>
				<td>{{ to_indDate($head->peneretur_date) }}</td>
			</tr>
		</table>
	</div>
</div>