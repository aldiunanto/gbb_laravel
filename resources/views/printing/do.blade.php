@extends('printing')
@section('content')

<header>
	<div class="caption">
		<h1>surat jalan</h1>
		<h2>no: {{ $numb }}</h2>
	</div>
	<table class="base-info">
		<tr>
			<td class="profile-info left">
				Industri Sepatu dan Keselamatan Kerja<br />
				PT. JALY INDONESIA UTAMA<br />
				JL. HM. Ashari No.47 Cibinong-Bogor<br />
				Telp: 021-2154501 Fax: 021-8752174
			</td>
			<td class="supp-info">
				<table>
					<tr>
						<td>Kepada Yth</td>
						<td>:</td>
						<td>{{ $head->sup_nama }}</td>
					</tr>
					<tr>
						<td>Alamat</td>
						<td>:</td>
						<td>{{ $head->sup_alamat }}</td>
					</tr>
					<tr>
						<td>Phone</td>
						<td>:</td>
						<td>{{ $head->sup_telepon }}</td>
					</tr>
					<tr>
						<td>Attn</td>
						<td>:</td>
						<td>{{ $head->sup_cp }}</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</header>
<section class="content">
	<div class="info">
		<span class="date">Tanggal&emsp;&emsp;&nbsp;:</span>
		<span class="po-no">Nomor PO&emsp;: {{ $head->po_no }}</span>
	</div>
	<table>
		<thead>
			<tr>
				<th>Barang</th>
				<th>Warna</th>
				<th>Spek</th>
				<th>Jumlah</th>
				<th>Satuan</th>
				<th>Keterangan</th>
			</tr>
		</thead>
		<tbody>
			<?php $x = 1 ?>
			@foreach($sub as $row)
			<tr>
				<td>{{ $row->mat_nama }}</td>
				<td>{{ $row->wrn_nama }}</td>
				<td>{{ $row->mat_spesifikasi }}</td>
				<td>{{ $row->returpeners_jml }}</td>
				<td>{{ $row->mats_nama }}</td>
				@if($x == 1)
				<td class="reason" rowspan="{{ $sub->count() }}">{{ $head->returpener_reason }}</td>
				@endif
			</tr>
			<?php $x++ ?>
			@endforeach

			@if($sub->count() < 5)
				@for($x = 1; $x <= (5 - $sub->count()); $x++)
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				@endfor
			@endif
		</tbody>
	</table>
</section>
<footer>
	<table>
		<tr>
			<td class="top" rowspan="2">Tanda Terima</td>
			<td rowspan="2">
				<h5>TELAH DIPERIKSA</h5>
				<table>
					<tr>
						<td>Gudang</td>
						<td>Satpam</td>
						<td>Supir</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
			</td>
			<td class="top">
				Hormat kami,<br />
				Staff Purch
			</td>
			<td class="top">
				Mengetahui,
			</td>
		</tr>
		<tr class="name">
			<td>{{ (! session('kar_nama_panggilan') ? session('kar_nama') : session('kar_nama_panggilan')) }}</td>
			<td>LIVIA YUWONO</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="iso-no">Form-ADM-036-1</td>
			<td colspan="2">&nbsp;</td>
		</tr>
	</table>
</footer>

@endsection