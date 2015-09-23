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
						<input type="text" name="po_no" id="po_no" disabled="disabled" style="width: 310px;" />
						<input type="hidden" name="po_id" />

						<a href="javascript:;" class="btn default open-po"><i class="fa fa-table"></i></a>
					</td>
					<td>
						<label for="pener_date">Tanggal Penerimaan</label>
						<input type="text" disabled="disabled" name="pener_date" id="pener_date" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="dorp_no">Nomor Surat Jalan</label>
						<input type="text" disabled="disabled" name="dorp_no" id="dorp_no" />
					</td>
					<td>
						<label for="created_at">Tanggal Diketahui</label>
						<input type="text" disabled="disabled" name="created_at" id="created_at" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="sup_nama">Supplier</label>
						<input type="text" name="sup_nama" id="sup_nama" disabled="disabled" style="width: 350px;" />
					</td>
					<td>
						<label for="rpi_date">Tanggal Kedatangan</label>
						<input type="text" name="rpi_date" id="rpi_date" value="{{ to_indDate(now()) }}" />
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>

@endsection