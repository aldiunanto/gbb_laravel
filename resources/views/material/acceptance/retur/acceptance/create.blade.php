@extends('base')
@section('content')

<div class="top">
	<div class="tools">&nbsp;</div>
	<h2>Form Penerimaan Returan</h2>
	<div class="clearfix"></div>
</div>
<div class="main">
	<div class="form">
		<div class="info warning">*<i>Penerimaan barang menggunakan satuan <strong>Purchasing!</strong></i></div>
		<form action="{{ url('material/acceptance/retur/inputStore') }}" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<table>
				<tr>
					<td>
						<label for="po_no">Nomor PO*</label>
						<input type="text" name="po_no" id="po_no" disabled="disabled" style="width: 310px;" value="{{ (!empty($head->po_no) ? $head->po_no : '') }}" />
						<input type="hidden" name="returpener_id" value="{{ (!empty($head->returpener_id) ? $head->returpener_id : '') }}" />

						<a href="javascript:;" class="btn default open-po"><i class="fa fa-table"></i></a>
					</td>
					<td>
						<label for="pener_date">Tanggal Penerimaan</label>
						<input type="text" disabled="disabled" name="pener_date" id="pener_date" value="{{ (!empty($head->pener_date) ? to_indDate($head->pener_date) : '') }}" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="dorp_no">Nomor Surat Jalan</label>
						<input type="text" disabled="disabled" name="dorp_no" id="dorp_no" value="{{ (!empty($head->dorp_no) ? $head->dorp_no : '') }}" />
					</td>
					<td>
						<label for="created_at">Tanggal Diketahui</label>
						<?php

							if(!empty($head->created_at)){
								$date = explode(' ', $head->created_at);
								$created_at = to_indDate($date[0]);
							}else{
								$created_at = '';
							}

						?>
						<input type="text" disabled="disabled" name="created_at" id="created_at" value="{{ $created_at }}" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="sup_nama">Supplier</label>
						<input type="text" name="sup_nama" id="sup_nama" disabled="disabled" style="width: 350px;" value="{{ (!empty($head->sup_nama) ? $head->sup_nama : '') }}" />
					</td>
					<td>
						<label for="rpi_date">Tanggal Kedatangan</label>
						<input type="text" name="rpi_date" id="rpi_date" value="{{ to_indDate(now()) }}" />
					</td>
				</tr>

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
									<th>Warna</th>
									<th>Diretur</th>
									<th>Diterima</th>
									<th>Satuan</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								@foreach($sub as $row)
								<tr>
									<td class="mat_nama">
										<input type="hidden" name="returpeners_id[]" value="{{ $row->returpeners_id }}" />
										{{ $row->mat_nama }}
									</td>
									<td class="mat_spesifikasi">{{ $row->mat_spesifikasi }}</td>
									<td class="warna">{{ $row->wrn_nama }}</td>
									<td class="returpeners_jml text-center">{{ $row->returpeners_jml }}</td>
									<td class="retur_diterima text-center">
										<input type="hidden" name="mat_id_{{ $row->returpeners_id }}" value="{{ $row->mat_id }}" />
										<input type="text" class="text-center peners" name="peners_jml_{{ $row->returpeners_id }}" required="required" />
									</td>
									<td class="satuan_p text-center">{{ $row->mats_nama }}</td>
									<td class="status text-center">
										
										<span class="status vice-approve label">Open</span>
										<span class="status pm-reject-vice label">Closed</span>
										
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</td>
				</tr>
				@endif

			</table>
		</form>
	</div>
</div>

@endsection