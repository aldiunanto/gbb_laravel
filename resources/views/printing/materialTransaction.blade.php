@extends('printing')
@section('content')

<header>
	<div class="caption">
		<h1>transaksi material</h1>
		<h2>{{ $period }}</h2>
	</div>
</header>
<section>
	<table>
		<thead>
			<tr>
				<th>No.</th>
				<th>material</th>
				<th>satuan</th>
				<th>spek</th>
				<th>warna</th>
				<th>supplier</th>
				<th>stok<br />minimum</th>
				<th>stok<br />awal</th>
			</tr>
		</thead>
		<tbody>
			<?php $y = 1; ?>
			@foreach($fetch as $row)
			<?php $stockAkhir = $row->mat_stock_awal ?>

			<tr class="item">
				<td rowspan="3" class="numb">{{ $y++ }}</td>
				<td class="left">{{ $row->mat_nama }}</td>
				<td>{{ $row->mats_nama }}</td>
				<td class="left">{{ $row->mat_spesifikasi }}</td>
				<td>{{ $row->wrn_nama }}</td>
				<td class="left">{{ $row->sup_nama }}</td>
				<td class="right">{{ numbFormat($row->mat_stock_min) }}</td>
				<td class="right">{{ numbFormat($row->mat_stock_awal) }}</td>
			</tr>
			<tr>
				<td colspan="7">
					<table class="transac-detail">
						<tr>
							<td></td>
							@for($x = 1; $x <= 31; $x++)
								@if(isWeekend($post['year'] . '-' . $post['month'] . '-' . $x))
									<td class="date weekend">{{ $x }}</td>
								@else
									<td class="date">{{ $x }}</td>
								@endif
							@endfor
							<td class="total">Total</td>
						</tr>
						<tr>
							<td>In</td>
							<?php $total = 0 ?>
							@for($x = 1; $x <= 31; $x++)
								<?php $date = ($post['year'] . '-' . (strlen($post['month']) == 1 ? ('0'.$post['month']) : $post['month']) . '-' . (strlen($x) == 1 ? ('0'.$x) : $x)) ?>
								@if(isWeekend($date))
									<td class="date weekend"></td>
								@else
									<td class="date">
										<?php $peners_jml = 0 ?>
										@foreach($Peners::getQuantity($row->mat_id, $date) as $each)
											<?php $peners_jml += ($each->peners_jml * $each->mat_perbandingan) ?>
										@endforeach
										<?php

											echo ($peners_jml == 0 ? '' : $peners_jml);
											$total += $peners_jml;

										?>
									</td>
								@endif
							@endfor
							<td class="total">{{ ($total == 0 ? '' : $total) }}</td>

							<?php $stockAkhir += $total ?>
						</tr>
						<tr>
							<td>Out</td>
							<?php $total = 0 ?>
							@for($x = 1; $x <= 31; $x++)
								<?php $date = ($post['year'] . '-' . (strlen($post['month']) == 1 ? ('0'.$post['month']) : $post['month']) . '-' . (strlen($x) == 1 ? ('0'.$x) : $x)) ?>
								@if(isWeekend($date))
									<td class="date weekend"></td>
								@else
									<td class="date">
										<?php $pengels_jml = 0 ?>
										@foreach($Pengels::getQuantity($row->mat_id, $date) as $each)
											<?php $pengels_jml += $each->pengels_realisasi ?>
										@endforeach
										<?php

											echo ($pengels_jml == 0 ? '' : $pengels_jml);
											$total += $pengels_jml;

										?>
									</td>
								@endif
							@endfor
							<td class="total">{{ ($total == 0 ? '' : $total) }}</td>

							<?php $stockAkhir -= $total ?>
						</tr>
						<tr>
							<td>Retur</td>
							<?php $total = 0 ?>
							@for($x = 1; $x <= 31; $x++)
								<?php $date = ($post['year'] . '-' . (strlen($post['month']) == 1 ? ('0'.$post['month']) : $post['month']) . '-' . (strlen($x) == 1 ? ('0'.$x) : $x)) ?>
								@if(isWeekend($date))
									<td class="date weekend"></td>
								@else
									<td class="date">
										<?php $retur_jml = 0 ?>
										@foreach($Returpeners::getQuantity($row->mat_id, $date) as $each)
											<?php $retur_jml += $each->returpeners_jml ?>
										@endforeach
										<?php

											echo ($retur_jml == 0 ? '' : $retur_jml);
											$total += $retur_jml;

										?>
									</td>
								@endif
							@endfor
							<td class="total">{{ ($total == 0 ? '' : $total) }}</td>

							<?php $stockAkhir -= $total ?>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="7">
					Stok Akhir: {{ $stockAkhir }}
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</section>

@endsection