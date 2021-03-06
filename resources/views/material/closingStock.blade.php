@extends('base')

@section('content')
<div class="top">
	<div class="tools">&nbsp;</div>
	<h2>Form Closing Stok</h2>
	<div class="clearfix"></div>
</div>
<div class="main">
	<div class="form">
		{!! session('success') !!}
		@if($isClosed)
		<div class="info error text-center"><i>Closing Stok sudah dilakukan pada tahun ini!<br /><strong>({{ $isClosed->created_at }})</strong></i></div>
		@endif
		@if(! $isDec)
		<div class="info error text-center"><i>Anda tidak diperkenankan melakukan Closing Stok sebelum bulan Desember!</i></div>
		@endif

		<div class="info warning">
			*<i>Closing Stok dilakukan <strong>satu kali dalam satu tahun</strong> di pengujung tahun yaitu <strong>pengujung Bulan Desember</strong>.</i><br />
			*<i>Closing Stok berfungsi untuk perhitungan stok material secara keseluruhan dalam transaksi (penerimaan, pengeluaran, dan retur) dan akan diperoleh sebuah hasil <strong>Stok Akhir</strong> yang lalu <strong>di-set sebagai Stok Awal</strong> pada tahun berikutnya.</i>
		</div>

		<form action="{{ url('material/closingStockDo') }}" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<table>
				<tr>
					<td>
						<label for="cs_year">Tahun</label>
						<input type="text" readonly="readonly" id="cs_year" name="year" value="{{ date('Y') }}" />
					</td>
				</tr>
				<tr>
					<td class="text-right">
						<div class="actions">
							<button class="btn primary" <?php echo ((!$isDec || $isClosed) ? 'disabled="disabled"' : '') ?>>close now!</button>
						</div>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
@endsection