<tr data-retur-content="{{ $pener_id }}">
	<td colspan="4">
		<table class="retur-content">
			<thead>
				<tr>
					<th>Material</th>
					<th>Jml Retur</th>
					<th>Alasan</th>

					@if($is_penerimaanReturan > 0)
					<th class="diterima">Diterima</th>
					<th class="diterima">Tgl Terima</th>
					@endif

					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				@foreach($fetch as $row)
				<tr>
					<td>{{ $row->mat_nama }}</td>
					<td class="text-right">{{ $row->returpeners_jml }}</td>
					<td class="text-center">{{ $row->returpeners_reason }}</td>
					<?php

						$pener = $Penereturs::getItem($row->returpeners_id);
						if($is_penerimaanReturan > 0 && $pener->count() > 0){
							$get = $pener->first();
					?>
							<td class="text-center diterima">{{ $get->penereturs_jml }}</td>
							<td class="text-center diterima">{{ to_indDate($get->peneretur_date) }}</td>
					<?php
						}
					?>

					<td class="text-center">
						<?php
							switch($row->returpener_status){
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
			</tbody>
		</table>
	</td>
</tr>