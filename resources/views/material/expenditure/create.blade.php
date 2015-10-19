@extends('base')

@section('content')
<div class="top">
	<div class="tools">&nbsp;</div>
	<h2>Form Pengeluaran Barang</h2>
	<div class="clearfix"></div>
</div>
<div class="main">
	<div class="form">

		<div class="info warning">*<i>Kolom yang bertanda bintang (*) wajib diisi</i>.</div>
		<div class="info warning">*<i>Pengeluaran barang menggunakan satuan <strong>Gudang</strong>.</i></div>

		<form action="{{ url('material/expenditure/store') }}" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<table>
				<tr>
					<td>
						<table>
							<tr>
								<td>
									<label for="dept_id">departemen <span class="required">*</span></label>
									<select name="dept_id" id="dept_id">
										<option value="">-- Pilih --</option>
										@foreach($deptbg as $row)
										<option value="{{ $row->deptbg_id }}">{{ $row->deptbg_nama }}</option>
										@endforeach
									</select>
								</td>
							</tr>
							<tr>
								<td>
									<label for="pengel_pbp">nomor BPB</label>
									<input type="text" name="pengel_pbp" id="pengel_pbp" />
								</td>
							</tr>
						</table>
					</td>
					<td>
						<table>
							<tr>
								<td>
									<label for="pengel_po">nomor PO</label>
									<input type="text" name="pengel_po" id="pengel_po" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="pengel_date">tanggal pengeluaran</label>
									<input type="text" name="pengel_date" id="pengel_date" class="date-picker" />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<div class="caption">
							<button class="btn default add-item"><i class="fa fa-plus"></i> add item</button>
							<h3>Material</h3>
						</div>
						<table class="data-list expenditure">
							<thead>
								<tr>
									<th rowspan="2">Material</th>
									<th rowspan="2">Warna</th>
									<th rowspan="2">Spesifikasi</th>
									<th colspan="2">Jumlah</th>
									<th rowspan="2">Keterangan</th>
									<th rowspan="2">&nbsp;</th>
								</tr>
								<tr>
									<th>Permintaan</th>
									<th>Realisasi</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="material text-center">
										<input type="text" name="mat_nama[]" id="mat_nama" readonly="readonly" />
										<input type="hidden" name="mat_id[]" />
										<input type="hidden" name="mat_perbandingan[]" />

										<a href="javascript:;" class="btn default open-material"><i class="fa fa-table"></i></a>
									</td>
									<td class="exp-warna text-center">&nbsp;</td>
									<td class="exp-spek text-center">&nbsp;</td>
									<td class="text-center"><input type="text" name="pengels_permintaan[]" class="text-center" /></td>
									<td class="text-center"><input type="text" name="pengels_realisasi[]" class="text-center" /></td>
									<td class="text-center"><input type="text" name="pengels_ket[]" /></td>
									<td class="text-right"><a href="javascript:;" class="btn danger remove-row"><i class="fa fa-remove"></i></a></td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td class="text-right" colspan="2">
						<div class="actions">
							<a href="{{ url('material/expenditure') }}" class="btn default"><i class="fa fa-mail-reply"></i>Batal</a>
							<button class="btn primary"><i class="fa fa-save"></i>Simpan</button>
						</div>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>

@endsection