@extends('base')

@section('content')
<div class="top">
	<div class="tools">&nbsp;</div>
	<h2>Form Retur Penerimaan</h2>
	<div class="clearfix"></div>
</div>
<div class="main">
	<div class="form">

		<form action="{{ url('material/acceptance/retur/store') }}" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<input type="hidden" name="pener_id" value="{{ $pener_id }}" />

			<div class="base-info">
				<span class="diketahui">Tanggal diketahui: {{ now() }}</span>

				<fieldset>
					<legend><h4>Informasi PO</h4></legend>
					<table>
						<tr>
							<td>Nomor PO</td>
							<td>:</td>
							<td><strong>{{ $head->po_no }}</strong></td>
						</tr>
						<tr>
							<td>Supplier</td>
							<td>:</td>
							<td>{{ $head->sup_nama }}</td>
						</tr>
						<tr>
							<td>Tanggal Penerimaan</td>
							<td>:</td>
							<td>{{ to_indDate($head->pener_date) }}</td>
						</tr>
						<tr>
							<td>Tanggal Input</td>
							<td>:</td>
							<td>
								<?php
									$created = explode(' ', $head->created_at);
									echo to_indDate($created[0]) . ' ' . $created[1];
								?>
							</td>
						</tr>
					</table>
				</fieldset>
			</div>
			<div class="caption">
				<h3>Material</h3>
			</div>
			<table class="data-list">
				<thead>
					<tr>
						<th>No</th>
						<th>Material</th>
						<th>Spesifikasi</th>
						<th>Warna</th>
						<th>Satuan</th>
						<th>Diterima</th>
						<th>Jml Retur</th>
					</tr>
				</thead>
				<tbody>
					<?php $x = 0; ?>
					@foreach($fetch as $row)
					<tr>
						<td class="text-right">{{ ++$x }}.</td>
						<td>{{ $row->mat_nama }}</td>
						<td>{{ $row->mat_spesifikasi }}</td>
						<td class="text-center">{{ empty($row->wrn_nama) ? '-' : $row->wrn_nama }}</td>
						<td class="text-center">{{ $row->mats_nama }}</td>
						<td class="text-right">{{ $row->peners_jml }}</td>
						<td class="text-center jml_retur">
							<input type="hidden" name="peners_id[]" value="{{ $row->peners_id }}" />
							<input type="text" name="jml_retur[]" class="text-right" />
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<div class="caption">
				<h3>Alasan Retur</h3>
			</div>
			<table>
				<tr>
					<td class="text-center"><textarea name="reason" placeholder="Alasan retur"></textarea></td>
				</tr>
			</table>
			<table>
				<tr>
					<td class="text-right">
						<div class="actions">
							<a href="{{ url('material/acceptance') }}" class="btn default"><i class="fa fa-mail-reply"></i>Batal</a>
							<button class="btn warning" name="save"><i class="fa fa-check"></i>Retur</button>
						</div>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>

@endsection