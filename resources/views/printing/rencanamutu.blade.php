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
		<?php $get = $Pener::fetchAll($row->po_id) ?>

			<tr>
				<td>{{ $row->po_tgl_buat }}</td>
				<td>{{ $row->po_no }}</td>
				<td class="left">&nbsp;</td>
				<td class="right">&nbsp;</td>
				<td>&nbsp;</td>
				<td>{{ $row->po_tgl_kedatangan }}</td>
				<td>
					<?php

						if($get->count() == 1){
							$each = $get->first();
							echo $each->pener_date;
						}

					?>
				</td>
			</tr>
			
		@endforeach

		</tbody>
	</table>
</section>

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