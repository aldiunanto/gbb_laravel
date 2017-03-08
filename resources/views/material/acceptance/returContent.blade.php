@foreach($fetch as $row)
<tr data-retur-content="{{ $pener_id }}">
	<td colspan="4">
		<table class="retur-content">
			<thead>
				<tr>
					<th>Material</th>
					<th>Spesifikasi</th>
					<th>Jml Retur</th>

					@if($is_penerimaanReturan($row->returpener_id) > 0)
					<th class="diterima">Diterima</th>
					<th class="diterima">Tgl Terima Trkhr</th>
					@endif

					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				@foreach($subRetur($row->returpener_id) as $sub)
				<tr>
					<td>{{ $sub->mat_nama }}</td>
					<td>{{ $sub->mat_spesifikasi }}</td>
					<td class="text-right">{{ $sub->returpeners_jml }}</td>
					<?php

						$pener = $Penereturs::getItem($sub->returpeners_id);
						if($is_penerimaanReturan($row->returpener_id) > 0 && $pener->count() > 0){

							$penersTotal = 0;
							foreach($pener as $pen){
								$penersTotal += $pen->penereturs_jml;
								$date = $pen->peneretur_date;
							}
					?>
							<td class="text-center diterima">{{ $penersTotal }}</td>
							<td class="text-center diterima">{{ to_indDate($date) }}</td>
					<?php
						}
					?>

					<td class="text-center">
						<?php
							switch($sub->returpener_status){
								case 1: echo '<span class="status wait-ppic" title="Menunggu persetujuan QA"><i class="fa fa-spinner fa-spin"></i></span>';  break;
								case 2: echo '<span class="status wait-vice" title="Menunggu persetujuan Kepala Produksi"><i class="fa fa-spinner fa-spin"></i></span>'; break;
								case 3: echo '<span class="status wait-ppic2" title="Menunggu persetujuan PPIC"><i class="fa fa-spinner fa-spin"></i></span>'; break;
								case 4: echo '<span class="status wait-vd" title="Menunggu persetujuan Vice Director"><i class="fa fa-spinner fa-spin"></i></span>'; break;
								case 5: echo '<span class="status vice-approve" title="Sudah di-approve Vice Director"><i class="fa fa-check"></i></span>'; break;
								case 6: echo '<span class="status po-done" title="Sudah dibuat Surat Jalan"><i class="fa fa-check"></i></span>'; break;
							}
						?>
					</td>
				</tr>
				@endforeach
				<tr>
					<td class="text-center" colspan="{{ ($is_penerimaanReturan($row->returpener_id) > 0 ? 6 : 4) }}">
						<em>Alasan: {{ ($row->returpener_reason ?: '-') }}</em>
					</td>
				</tr>
			</tbody>
		</table>
	</td>
</tr>
@endforeach