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
				<th>stok<br />akhir</th>
			</tr>
		</thead>
		<tbody>
			<?php $y = 1; ?>
			@foreach($fetch as $row)
			<tr class="item">
				<td rowspan="2" class="numb">{{ $y++ }}</td>
				<td class="left">{{ $row->mat_nama }}</td>
				<td>{{ $row->mats_nama }}</td>
				<td class="left">{{ $row->mat_spesifikasi }}</td>
				<td>{{ $row->wrn_nama }}</td>
				<td class="left">{{ $row->sup_nama }}</td>
				<td class="right">{{ numbFormat($row->mat_stock_min) }}</td>
				<td class="right">{{ numbFormat($row->mat_stock_awal) }}</td>
				<td class="right">{{ numbFormat(1425) }}</td>
			</tr>
			<tr>
				<td colspan="8">
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
										{{ ($peners_jml == 0 ? '' : $peners_jml) }}
									</td>
								@endif
							@endfor
							<td class="total"></td>
						</tr>
						<tr>
							<td>Out</td>
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
										{{ ($pengels_jml == 0 ? '' : $pengels_jml) }}
									</td>
								@endif
							@endfor
							<td class="total"></td>
						</tr>
						<tr>
							<td>Retur</td>
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
										{{ ($retur_jml == 0 ? '' : $retur_jml) }}
									</td>
								@endif
							@endfor
							<td class="total"></td>
						</tr>
					</table>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</section>

@endsection