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
			<tr>
				<td rowspan="2" class="numb">1.</td>
				<td>Kulit Milling</td>
				<td>SQF</td>
				<td>1.6mm - 1.8mm</td>
				<td>Brown</td>
				<td>UD. Rizky</td>
				<td>1000</td>
				<td>1200</td>
				<td>1425</td>
			</tr>
			<tr>
				<td colspan="8">
					<table class="transac-detail">
						<tr>
							<td></td>
							@for($x = 1; $x <= 31; $x++)
							<td class="date <?php echo (isWeekend($post['year'] . '-' . $post['month'] . '-' . $x) ? 'weekend' : '') ?>">{{ $x }}</td>
							@endfor
							<td class="total">Total</td>
						</tr>
						<tr>
							<td>In</td>
							@for($x = 1; $x <= 31; $x++)
							<td class="right <?php echo (isWeekend($post['year'] . '-' . $post['month'] . '-' . $x) ? 'weekend' : '') ?>"></td>
							@endfor
							<td class="total"></td>
						</tr>
						<tr>
							<td>Out</td>
							@for($x = 1; $x <= 31; $x++)
							<td class="right <?php echo (isWeekend($post['year'] . '-' . $post['month'] . '-' . $x) ? 'weekend' : '') ?>"></td>
							@endfor
							<td class="total"></td>
						</tr>
						<tr>
							<td>Retur</td>
							@for($x = 1; $x <= 31; $x++)
							<td class="right <?php echo (isWeekend($post['year'] . '-' . $post['month'] . '-' . $x) ? 'weekend' : '') ?>"></td>
							@endfor
							<td class="total"></td>
						</tr>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</section>

@endsection