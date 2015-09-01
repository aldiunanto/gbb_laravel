@extends('base')

@section('content')
<div class="top">
	<div class="tools">&nbsp;</div>
	<h2>Ubah Harga Material</h2>
	<div class="clearfix"></div>
</div>
<div class="main">
	<div class="form">
		<div class="info warning">
			*<i>Gunakan titik(.) untuk bilangan yang mengandung koma.</i>
		</div>

		<form action="{{ url('material/store') }}" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<input type="hidden" name="method" value="price" />
			<input type="hidden" name="sup_id" value="{{ $head->sup_id }}" />
		
			<table>
				<tr>
					<td>
						<div class="caption">
							<h3>Supplier: {{ $head->sup_nama }}</h3>
						</div>
						<table class="data-list">
							<thead>
								<tr>
									<th>No</th>
									<th>Material</th>
									<th>Spesifikasi</th>
									<th>Warna</th>
									<th>Mata Uang</th>
									<th>Ubah Harga</th>
								</tr>
							</thead>
							<tbody>
								<?php $x = 0 ?>
								@foreach($fetch as $row)
								<tr>
									<td class="text-right">{{ ++$x }}</td>
									<td>{{ $row->mat_nama }}</td>
									<td>{{ $row->mat_spesifikasi }}</td>
									<td>{{ $row->wrn_nama }}</td>
									<td>{{ $row->mu_shortcut }}</td>
									<td>
										<input type="hidden" name="mat_id[]" value="{{ $row->mat_id }}" />
										<input type="text" name="mat_price[]" value="{{ $row->mat_harga }}" />
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td class="text-right">
						<div class="actions">
							<a href="{{ url('material') }}" class="btn default"><i class="fa fa-mail-reply"></i>Batal</a>
							<button class="btn primary"><i class="fa fa-save"></i>Simpan</button>
						</div>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
@endsection