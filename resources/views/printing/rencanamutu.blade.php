@extends('printing')
@section('content')

<header>
	<div class="caption">
		<h1>report rencana mutu</h1>
		<h2>oktober 2015</h2>
	</div>
</header>
<section>
	<h3>ppn</h3>
	<table class="data-list">
		<thead>
			<tr>
				<th>Tanggal</th>
				<th>Nomor PO</th>
				<th>Material</th>
				<th>QTY</th>
				<th>Unit</th>
				<th>Tgl Permintaan</th>
				<th>Tgl Datang</th>
			</tr>
		</thead>
		<tbody>
		@foreach($fetch as $row)
			<tr>
				<td>{{ $row->po_tgl_buat }}</td>
				<td>{{ $row->po_no }}</td>

			<?php $sub = $Posub::fetchDetail($row->po_id); $x = 1; ?>
			@foreach($sub as $item)
				@if($x > 1)
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
				@endif

						<td class="left">{{ $item->mat_nama }}</td>
						<td class="right">{{ $item->pbs_jml }}</td>
						<td>{{ $item->mats_nama }}</td>
						<td>{{ $row->po_tgl_kedatangan }}</td>
						<td></td>
					</tr>

				<?php $x++ ?>
			@endforeach

		@endforeach
		</tbody>
	</table>
</section>

<section>
	<h3>example</h3>
	<table class="data-list">
		<thead>
			<tr>
				<th>Tanggal</th>
				<th>Nomor PO</th>
				<th>Material</th>
				<th>QTY</th>
				<th>Unit</th>
				<th>Tgl Permintaan</th>
				<th>Tgl Datang</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>02-10-2015</td>
				<td>P/501/X/JIU/15</td>
				<td class="left">M E K (Methil Ethil Kethon)</td>
				<td class="right">200</td>
				<td>Pcs</td>
				<td>05-10-2015</td>
				<td>05-10-2015</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td class="left">Kulit Cicak</td>
				<td class="right">400</td>
				<td>Sqf</td>
				<td>05-10-2015</td>
				<td>05-10-2015</td>
			</tr>
			<tr>
				<td>03-10-2015</td>
				<td>P/502/X/JIU/15</td>
				<td class="left">Kaos Kutang</td>
				<td class="right">80</td>
				<td>Meter</td>
				<td>18-10-2015</td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td class="right partial">35</td>
				<td class="partial"></td>
				<td class="partial"></td>
				<td class="partial">10-10-2015</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td class="right partial">45</td>
				<td class="partial"></td>
				<td class="partial"></td>
				<td class="partial">12-10-2015</td>
			</tr>
		</tbody>
	</table>
</section>

@endsection