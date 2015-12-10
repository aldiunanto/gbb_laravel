@extends('base')

@section('content')
<div class="top">
	<div class="tools">&nbsp;</div>
	<h2>Form Closing Stok</h2>
	<div class="clearfix"></div>
</div>
<div class="main">
	<div class="form">
		<form action="{{ url('material/closingStockDo') }}" method="post" target="_blank">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<table>
				<tr>
					<td>
						<label for="cs_year">Tahun</label>
						<input type="text" disabled="disabled" id="cs_year" name="year" value="{{ date('Y') }}" />
					</td>
				</tr>
				<tr>
					<td class="text-right">
						<div class="actions">
							<button class="btn primary">close now!</button>
						</div>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
@endsection