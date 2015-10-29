@extends('printing')
@section('content')

<header>
	<div class="caption">
		<h1>report rencana mutu</h1>
		<h2>oktober 2015</h2>
	</div>
</header>
<section>
	<table class="data-list">
		<thead>
			<tr>
				<th>Tanggal</th>
				<th>Nomor PO</th>
				<th>Material</th>
				<th>QTY</th>
				<th>Unit</th>
				<th>Tgl Kirim</th>
				<th>Tgl Datang</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="bordered-left">02-10-2015</td>
				<td>P/501/X/JIU/15</td>
				<td>M E K (Methil Ethil Kethon)</td>
				<td>200</td>
				<td>Pcs</td>
				<td>05-10-2015</td>
				<td class="bordered-right">05-10-2015</td>
			</tr>
			<tr>
				<td class="bordered-left"></td>
				<td></td>
				<td>Kulit Cicak</td>
				<td>400</td>
				<td>Sqf</td>
				<td>05-10-2015</td>
				<td class="bordered-right">05-10-2015</td>
			</tr>
			<tr>
				<td class="bordered-left">03-10-2015</td>
				<td>P/502/X/JIU/15</td>
				<td>Kaos Kutang</td>
				<td>80</td>
				<td>Meter</td>
				<td>18-10-2015</td>
				<td class="bordered-right"></td>
			</tr>
			<tr class="partial">
				<td class="bordered-left"></td>
				<td></td>
				<td></td>
				<td>35</td>
				<td></td>
				<td></td>
				<td class="bordered-right">10-10-2015</td>
			</tr>
			<tr class="partial">
				<td class="bordered-left"></td>
				<td></td>
				<td></td>
				<td>45</td>
				<td></td>
				<td></td>
				<td class="bordered-right">12-10-2015</td>
			</tr>
		</tbody>
	</table>
</section>

@endsection