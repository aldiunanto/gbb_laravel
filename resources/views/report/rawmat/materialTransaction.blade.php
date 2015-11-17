@extends('base')

@section('content')
<div class="top">
	<div class="tools">&nbsp;</div>
	<h2>form laporan pembelian bulanan</h2>
	<div class="clearfix"></div>
</div>
<div class="main">
	<div class="form">
		<form action="{{ url('printing/purchasemonthly') }}" method="post" target="_blank">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<table>
				<tr>
					<td>
						<label for="month">Pilih Bulan <span class="required">*</span></label>
						<select name="month" id="month" required="required">
							<option value=""></option>
							@for($x = 1; $x <= 12; $x++)
							<option value="{{ $x }}">{{ $months[$x] }}</option>
							@endfor
						</select>
					</td>
					<td>
						<label for="year">Pilih Tahun <span class="required">*</span></label>
						<select name="year" id="year" required="required">
							<option value=""></option>
							@for($x = date('Y'); $x >= 2010; $x--)
							<option value="{{ $x }}">{{ $x }}</option>
							@endfor
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for="sort_by">Sorot Berdasarkan</label>
						<select name="sort_by" id="sort_by">
							<option value="pener_date">Tanggal Penerimaan</option>
							<option value="sup_nama">Supplier</option>
						</select>
					</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="2" class="text-right">
						<div class="actions">
							<button class="btn primary">buat laporan <i class="fa fa-hand-o-right"></i></button>
						</div>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
@endsection