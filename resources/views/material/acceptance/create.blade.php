@extends('base')

@section('content')
<div class="top">
	<div class="tools">&nbsp;</div>
	<h2>Form Penerimaan Barang</h2>
	<div class="clearfix"></div>
</div>
<div class="main">
	<div class="form">
		<div class="info warning">*<i>Penerimaan barang menggunakan satuan <strong>Purchasing!</strong></i></div>

		<form action="{{ url('material/acceptance/store') }}" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<table>
				<tr>
					<td>
						<table>
							<tr>
								<td>
									<label for="po_no">Nomor PO</label>
									<input type="text" name="po_no" id="po_no" disabled="disabled" style="width: 310px;" value="{{ (!empty($head->po_no) ? $head->po_no : '') }}" />
									<input type="hidden" name="po_id" value="{{ (!empty($head->po_id) ? $head->po_id : '') }}" />

									<a href="javascript:;" class="btn default open-po"><i class="fa fa-table"></i></a>
								</td>
							</tr>
							<tr>
								<td>
									<label for="sup_nama">supplier</label>
									<input type="text" name="sup_nama" id="sup_nama" disabled="disabled" style="width: 350px" value="{{ (!empty($head->sup_nama) ? $head->sup_nama : '') }}" />
								</td>
							</tr>
						</table>
					</td>
					<td>
						<table>
							<tr>
								<td>
									<label for="po_tgl_kedatangan">tanggal dibutuhkan</label>
									<input type="text" name="po_tgl_kedatangan" id="po_tgl_kedatangan" disabled="disabled" value="{{ (!empty($head->po_tgl_kedatangan) ? to_indDate($head->po_tgl_kedatangan) : '') }}" />
								</td>
							</tr>
							<tr>
								<td>
									<label for="pener_date">tanggal kedatangan</label>
									<input type="text" name="pener_date" id="pener_date" disabled="disabled" value="<?php echo to_indDate(date('Y-m-d')) ?>" />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<?php $el = array(); ?>
				@if(! empty($sub))
				<tr>
					<td colspan="2">
						<div class="caption">
							<h3>Material</h3>
						</div>
						<table class="data-list">
							<thead>
								<tr>
									<th>Material</th>
									<th>Spesifikasi</th>
									<th>Permintaan</th>
									<th>Telah Diterima</th>
									<th>Diterima</th>
									<th>Satuan</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								@foreach($sub as $row)
								<?php $diterima = countDiterima($row->pos_id); $rest = $row->pbs_jml - $diterima; ?>
								<tr>
									<td class="mat_nama">
										<input type="hidden" name="pos_id[]" value="{{ $row->pos_id }}" />
										{{ $row->mat_nama }}
									</td>
									<td class="mat_spesifikasi text-center">{{ $row->mat_spesifikasi }}</td>
									<td class="pbs_jml text-center">{{ $row->pbs_jml }}</td>
									<td class="diterima text-center">{{ $diterima }}</td>
									<td class="peners_jml text-center">
										@if($rest > 0)
										<input type="hidden" name="mat_id_{{ $row->pos_id }}" value="{{ $row->mat_id }}" />
										<input type="text" class="text-center peners" name="peners_jml_{{ $row->pos_id }}" required="required" />
										@else
										-
										@endif
									</td>
									<td class="satuan_p text-center">{{ $row->mats_nama }}</td>
									<td class="status text-center">
										@if($rest > 0)
										<?php array_push($el, 'open') ?>
										<span class="status vice-approve label">Open</span>

										@elseif($rest < 0)
										<span class="status po-done label">Over</span>

										@else
										<span class="status pm-reject-vice label">Closed</span>
										@endif
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</td>
				</tr>
				@endif

				<?php

					if(! empty($sub) && ! in_array('open', $el)){ $class = 'hidden'; }
					else{ $class = ''; }

					if(empty($sub) || $head->po_status == 2){ $class = 'hidden'; }

				?>
				
				<tr>
					<td class="text-right" colspan="2">
						<div class="actions {{ $class }}">
							<a href="{{ url('material/acceptance') }}" class="btn default"><i class="fa fa-mail-reply"></i>Batal</a>
							<button class="btn primary"><i class="fa fa-save"></i>Simpan</button>
						</div>

						@if(! empty($head->po_status) && $head->po_status == 2)
						<div class="info error text-center">Anda tidak bisa melakukan input untuk PO ini karena statusnya sudah <strong>CLOSED</strong></div>
						@endif
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
@endsection