@extends('printing')

@section('content')

<header>
	<div id="tagline">
		<div>
			<h1>surat pesanan</h1>
			<h1>{{ $head->po_no }}</h1>
		</div>
		<div <?php echo ($head->po_is_ppn == 2 ? 'style="display: none;"' : '') ?>>
			<h1>pt. jaly indonesia utama</h1>
			Jl. H.M. Asyari No.47 Cibinong-Bogor 16911<br />
			Telp. (021) 875 4501&emsp;Fax. (021) 875 2174
		</div>
		<div class="endfloat"></div>
	</div>
	<div id="base-info">
		<table>
			<tr>
				<td class="parent top-left" style="vertical-align: top;">
					<table>
						<tr>
							<td class="left" style="width: 90px; vertical-align: top;">Kepada</td>
							<td style="width: 15px; vertical-align: top;">:</td>
							<td class="left">{{ $head->sup_nama }}</td>
						</tr>
						<tr>
							<td class="left" style="vertical-align: top;">Alamat</td>
							<td style="vertical-align: top;">:</td>
							<td class="left"><span class="rawmat">{{ $head->sup_alamat }}</span></td>
						</tr>
						<tr>
							<td class="left">Telepon</td>
							<td>:</td>
							<td class="left"><span class="rawmat">{{ $head->sup_telepon }}</span></td>
						</tr>
						<tr>
							<td class="left">Fax</td>
							<td>:</td>
							<td class="left"><span class="rawmat">{{ $head->sup_fax }}</span></td>
						</tr>
						<tr>
							<td class="left">Contact Person</td>
							<td>:</td>
							<td class="left"><span class="rawmat">{{ $head->sup_cp }}</span></td>
						</tr>
					</table>
				</td>
				<td class="parent" style="vertical-align: top;">
					<table>
						<tr>
							<td class="left" style="width: 115px;">Tanggal PO</td>
							<td style="width: 15px;">:</td>
							<td class="left">{{ to_indDate($head->po_tgl_buat) }}</td>
						</tr>
						<tr>
							<td class="left">Tanggal Pengiriman</td>
							<td>:</td>
							<td class="left">{{ to_indDate($head->po_tgl_kedatangan) }}</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<form class="hidden-element" style="float: right;">
			<label for="check-for-rawmat">Cetak ke Rawmat</label>
			<input type="checkbox" style="vertical-align: middle;" id="check-for-rawmat" />
		</form>
		<div class="endfloat"></div>
	</div>
</header>
<section>
	<table>
		<thead>
			<tr>
				<td>QTY</td>
				<td>satuan</td>
				<td>nama barang</td>
				<td>warna</td>
				<td>spesifikasi</td>
				<td class="rawmat">harga satuan</td>
				<td class="rawmat">diskon</td>
				<td class="rawmat">jumlah</td>
			</tr>
		</thead>
		<tbody>
			<?php $x = 0; $total = 0; ?>
			@foreach($sub as $row)
			<?php
				$subJml = ($row->pos_harga - (($row->pos_harga * $row->pos_discount) / 100)) * $row->pbs_jml; $total += $subJml;
				if($sub->count() > 5){
					$borderedBottom = '';
				}else{
					$borderedBottom = ($x == 5 ? 'bordered-bottom' : '');
				}
			?>
			<tr>
				<td class="bordered-left <?php echo $borderedBottom ?>">{{ number_format($row->pbs_jml, 0, null, '.') }}</td>
				<td class="<?php echo $borderedBottom ?>">{{ $row->mats_nama }}</td>
				<td class="left <?php echo $borderedBottom ?>">{{ $row->mat_nama }}</td>
				<td class="<?php echo $borderedBottom ?>">{{ $row->wrn_nama }}</td>
				<td class="spek <?php echo $borderedBottom ?>">{{ $row->mat_spesifikasi }}</td>
				<td class="left rawmat <?php echo $borderedBottom ?>"><?php echo $row->mu_shortcut . '<span class="money">' . number_format($row->pos_harga, 0, null, '.') . '</span>' ?></td>
				<td class="rawmat <?php echo $borderedBottom ?>">{{ $row->pos_discount }}%</td>
				<td class="bordered-right left rawmat <?php echo $borderedBottom ?>"><?php echo $row->mu_shortcut . '<span class="money">' . number_format($subJml, 0, null, '.') . '</span>' ?></td>
			</tr>
			<?php $x++; ?>
			@endforeach

			@for($y = 1; $y <= (6 - $x); $y++)
			@if($y == (6 - $x))
			<tr>
				<td colspan="8" class="bordered-bottom bordered-left bordered-right bottom">&nbsp;</td>
			</tr>
			@else
			<tr>
				<td class="bordered-left">&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td class="spek">&nbsp;</td>
				<td class="rawmat">&nbsp;</td>
				<td class="rawmat">&nbsp;</td>
				<td class="bordered-right rawmat">&nbsp;</td>
			</tr>
			@endif
			@endfor

			@if($sub->count() > 5)
			<tr>
				<td colspan="8" class="bordered-bottom bordered-left bordered-right bottom">&nbsp;</td>
			</tr>
			@endif
		</tbody>
	</table>
</section>
<footer>
	<table>
		<tr>
			<td style="vertical-align: top;">
				<table>
					<tr>
						@if($head->po_is_ppn == 2)
						<td style="width: 35px;" class="left">&nbsp;</td>
						<td class="left">&nbsp;</td>
						@else
						<td style="width: 43px;" class="left">Note :</td>
						<td class="left">{{ $head->po_note }}</td>
						@endif
					</tr>
				</table>
			</td>
			<td style="width: 300px" class="rawmat">
				<?php $mu_shortcut = (! empty($row->mu_shortcut) ? $row->mu_shortcut : '') ?>
				<table>
					@if($head->po_is_ppn != 2)
					<tr>
						<td class="left">Total</td>
						<td>:</td>
						<td class="left"><?php echo $mu_shortcut . '<span class="money">' . number_format($total, 2, ',', '.') . '</span>' ?></td>
					</tr>
					@endif
					@if($head->po_is_use_ppn == 1)
					<tr>
						<td class="left">PPN</td>
						<td>:</td>
						<td class="left"><?php $ppn = ($total * 0.1); echo $mu_shortcut . '<span class="money">' . number_format($ppn, 2, ',', '.') . '</span>' ?></td>
					</tr>
					@endif

					<tr class="total">
						<td class="left">Total Bayar</td>
						<td>:</td>
						<td class="left">
							<?php

								$theppn = (! empty($ppn) ? $ppn : 0);
								$bayar = $total + $theppn;

								echo $mu_shortcut . '<span class="money">' . number_format($bayar, 2, ',', '.') . '</span>';

							?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	@if($head->po_is_ppn != 2)
	<table class="signature">
		<tr>
			<td>Purchasing</td>
			<td>Vice Director</td>
		</tr>
		<tr>
			<td>{{ (! session('kar_nama_panggilan') ? session('kar_nama') : session('kar_nama_panggilan')) }}</td>
			<td>Livia Yuwono</td>
		</tr>
		<tr>
			<td colspan="2" class="right" style="font-weight: normal">Form-ADM-012-1</td>
		</tr>
	</table>
	@endif
</footer>

@endsection