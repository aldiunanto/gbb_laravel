<div class="po-detail">
	<div class="base-info">
		<table>
			<tr>
				<td colspan="6" class="text-center" style="padding-bottom: 5px;"><strong>{{ $head->po_no }}</strong></td>
			</tr>
			<tr>
				<td class="field">Kepada</td>
				<td class="colon">:</td>
				<td>{{ $head->sup_nama }}</td>
				<td class="field">Tgl Order</td>
				<td class="colon">:</td>
				<td>
					<?php

						$path = explode(' ', $head->created_at);
						echo to_indDate($path[0]) . ' ' . $path[1];

					?>
				</td>
			</tr>
			<tr>
				<td class="field">Alamat</td>
				<td class="colon">:</td>
				<td>{{ (! in_array($role, [3, 4, 8]) ? $head->sup_alamat : '-') }}</td>
				<td class="field">Dibutuhkan</td>
				<td class="colon">:</td>
				<td>{{ to_indDate($head->po_tgl_kedatangan) }}</td>
			</tr>
			<tr>
				<td class="field">Telepon</td>
				<td class="colon">:</td>
				<td>{{ (! in_array($role, [3, 4, 8]) ? $head->sup_telepon : '-') }}</td>
				<td class="field">Tgl Approve</td>
				<td class="colon">:</td>
				<td>
					<?php

						$path = explode(' ', $head->vd_approved_at);
						echo to_indDate($path[0]) . ' ' . $path[1];

					?>
				</td>
			</tr>
			<tr>
				<td class="field">Contact Person</td>
				<td class="colon">:</td>
				<td>{{ (! in_array($role, [3, 4, 8]) ? $head->sup_cp : '-') }}</td>
				<td class="field">Tanggal PO</td>
				<td class="colon">:</td>
				<td>{{ to_indDate($head->po_tgl_buat) }}</td>
			</tr>
			<tr>
				<td class="field">Nomor GBB</td>
				<td class="colon">:</td>
				<td>{{ $head->pb_no }}</td>
				<td class="field">Catatan</td>
				<td class="colon">:</td>
				<td>{{ $head->po_note }}</td>
			</tr>
			<tr>
				<td class="field"></td>
				<td class="colon"></td>
				<td></td>
				<td class="field">Fax</td>
				<td class="colon">:</td>
				<td>{{ (! in_array($role, [3, 4, 8]) ? $head->sup_fax : '-') }}</td>
			</tr>
		</table>
	</div>
	<table class="data-list">
		<thead>
			<tr>
				<th>Qty</th>
				<th>Satuan</th>
				<th>Nama Barang</th>
				<th>Warna</th>
				<th>Spesifikasi</th>
				@if(! in_array($role, [3, 4, 8]))
				<th>Harga</th>
				<th>Diskon</th>
				<th>Jumlah</th>
				@endif
			</tr>
		</thead>
		<tbody>
			@foreach($sub as $row)
			<?php
				$subJml = ($row->pos_harga - (($row->pos_harga * $row->pos_discount) / 100)) * $row->pbs_jml;
			?>
			<tr>
				<td>{{ $row->pbs_jml }}</td>
				<td>{{ $row->mats_nama }}</td>
				<td>{{ $row->mat_nama }}</td>
				<td>{{ $row->wrn_nama }}</td>
				<td>{{ $row->mat_spesifikasi }}</td>
				@if(! in_array($role, [3, 4, 8]))
				<td class="text-left"><?php echo $row->mu_shortcut . '<span style="float: right">' . number_format($row->pos_harga, 0, null, '.') . '</span>' ?></td>
				<td class="text-center">{{ $row->pos_discount }}%</td>
				<td class="text-left"><?php echo $row->mu_shortcut . '<span style="float: right">' . number_format($subJml, 0, null, '.') . '</span>' ?></td>
				@endif
			</tr>
			@endforeach
		</tbody>
	</table>
</div>