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
	<div class="list">
		<table class="data-list">
			<thead>
				<tr>
					<th>Material</th>
					<th>Spesifikasi</th>
					<th>Warna</th>
					<th>Diterima</th>
					<th>Satuan</th>
				</tr>
			</thead>
			<tbody>
				@foreach($fetch as $row)
				<?php $isRetur = $Returpener::isRetur($row->pener_id) ?>

				<tr class="new-pener">
					<td colspan="5">
						@if($isRetur == 0 && ($role == 1 || $role == 3))
						<?php //if($head->po_status == 1 && $isRetur == 0 && ($role == 1 || $role == 3)) ?>
						<!-- <a href="{{ url('material/acceptance/retur/create/' . $row->pener_id) }}" class="btn warning" style="float: right;"><i class="fa fa-rotate-left"></i>Retur</a> -->
						@endif

						<a href="{{ url('material/acceptance/retur/create/' . $row->pener_id) }}" class="btn warning" style="float: right;"><i class="fa fa-rotate-left"></i>Retur</a>

						{{ to_indDate($row->pener_date) }}
						@if($isRetur > 0)
						<a href="javascript:;" class="expand-retur" data-id="{{ $row->pener_id }}">Lihat Returan <i class="fa fa-angle-down"></i></a>
						@endif
					</td>
				</tr>
					@foreach($Peners::fetchDetail(['B.pener_id' => $row->pener_id]) as $sub)
					<tr data-id="{{ $row->pener_id }}">
						<td class="mat-nama">{{ $sub->mat_nama }}</td>
						<td class="text-center">{{ $sub->mat_spesifikasi }}</td>
						<td class="text-center">{{ $sub->wrn_nama }}</td>
						<td class="text-right">{{ $sub->peners_jml }}</td>
						<td class="text-center">{{ $sub->mats_nama }}</td>
					</tr>
					@endforeach
				@endforeach
			</tbody>
		</table>
	</div>
</div>