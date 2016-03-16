@extends('base')

@section('content')
<div class="top">
	<div class="tools">&nbsp;</div>
	<h2>Form Pembuatan PO</h2>
	<div class="clearfix"></div>
</div>
<div class="main">
	<div class="form">

		<div class="info warning">*<i>Kolom yang bertanda bintang (*) wajib diisi</i>.</div>
		@if (count($errors) > 0)
	        @foreach ($errors->all() as $error)
	          <div class="info error">{{ $error }}</div>
	        @endforeach
	    @endif

		<form action="{{ url('po/store') }}" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<input type="hidden" name="pb_id" value="{{ $pb_id }}" />

			<table>
				<tr>
					<td class="text-center" colspan="2">
						<a href="javascript:;" class="generate-numb btn default" data-type="ppn">PPN</a>
						<a href="javascript:;" class="generate-numb btn default" data-type="non">Non PPN</a>
					</td>
				</tr>
				<tr>
					<td>
						<table>
							<tr>
								<td>
									<label for="po_no">nomor PO <span class="required">*</span></label>
									<input type="text" name="po_no" id="po_no" required="required" value="{{ old('po_no') }}" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="sup_nama">kepada</label>
									<input type="text" name="sup_nama" id="sup_nama" value="{{ $head->sup_nama }}" class="date-picker" disabled="disabled" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="sup_alamat">alamat</label>
									<input type="text" name="sup_alamat" id="sup_alamat" value="{{ $head->sup_alamat }}" disabled="disabled" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="sup_telepon">telepon</label>
									<input type="text" name="sup_telepon" id="sup_telepon" value="{{ $head->sup_telepon }}" disabled="disabled" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="sup_cp">contact person</label>
									<input type="text" name="sup_cp" id="sup_cp" value="{{ $head->sup_cp }}" disabled="disabled" />
								</td>
							</tr>
						</table>
					</td>
					<td>
						<table>
							<tr>
								<td>
									<label for="po_tgl_buat">tanggal PO <span class="required">*</span></label>
									<input type="text" name="po_tgl_buat" required="required" id="po_tgl_buat" value="{{ date('Y-m-d') }}" class="date-picker" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="po_tgl_kedatangan">tanggal dibutuhkan <span class="required">*</span></label>
									<input type="text" name="po_tgl_kedatangan" required="required" id="po_tgl_kedatangan" class="date-picker" value="{{ $head->pb_tgl_butuh }}" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="po_note">catatan</label>
									<textarea name="po_note" id="po_note">{{ $head->pb_note }}</textarea>
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr>
					<td colspan="2">
						<div class="caption">
							<h3>Material</h3>
						</div>
						<table class="data-list po-sub">
							<thead>
								<tr>
									<th>Material</th>
									<th>Spesifikasi</th>
									<th>Warna</th>
									<th>Harga</th>
									<th>Satuan</th>
									<th>Diskon</th>
									<th>Qty</th>
									<th>Sub Total</th>
								</tr>
							</thead>
							<tbody>
								<?php $total = 0; ?>
								@foreach($sub as $row)
								<?php $subtotal = $row->mat_harga * $row->pbs_jml; $total += $subtotal; ?>
								<tr>
									<td>
										{{ $row->mat_nama }}
										<input type="hidden" name="pbs_id[]" value="{{ $row->pbs_id }}" />
										<input type="hidden" name="pos_harga[]" value="{{ $row->mat_harga }}" />
									</td>
									<td>{{ $row->mat_spesifikasi }}</td>
									<td>{{ $row->wrn_nama }}</td>
									<td class="text-left"><?php echo $row->mu_shortcut . '<span class="money">' . $row->mat_harga . '</span>' ?></td>
									<td>{{ $row->mats_nama }}</td>
									<td class="text-center"><input type="text" class="discount" name="pos_discount[]" value="0" />%</td>
									<td class="text-center">{{ $row->pbs_jml }}</td>
									<td class="text-left"><?php echo $row->mu_shortcut . '<span class="money">' . $subtotal . '</span>' ?></td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table class="total">
							<tr class="row-total">
								<td class="text-right">Jumlah</td>
								<td class="colon">:</td>
								<td class="text-left"><?php echo $row->mu_shortcut . '<span class="money">' . $total . '</span>' ?></td>
							</tr>
							<tr class="row-ppn">
								<td class="text-right">PPN(10%)</td>
								<td class="colon">:</td>
								<td class="text-left">
									<?php
										$ppn = ($total * 10) / 100;
										echo $row->mu_shortcut . '<span class="money">' . $ppn . '</span>';

										$final = $total + $ppn;
									?>
								</td>
							</tr>
							<tr class="row-final">
								<td class="text-right">Total</td>
								<td class="colon">:</td>
								<td class="text-left"><?php echo $row->mu_shortcut . '<span class="money">' . $final . '</span>' ?></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td class="text-right" colspan="2">
						<div class="actions">
							<a href="{{ url('material/request') }}" class="btn default"><i class="fa fa-mail-reply"></i>Batal</a>
							<button class="btn primary" name="save"><i class="fa fa-save"></i>Simpan</button>
							<button class="btn warning" name="save_print"><i class="fa fa-save"></i>Simpan &amp; Cetak</button>
						</div>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
@endsection