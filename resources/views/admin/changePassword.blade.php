@extends('base')

@section('content')
<div class="top">
	<div class="tools">&nbsp;</div>
	<h2>Ubah Password</h2>
	<div class="clearfix"></div>
</div>
<div class="main">
	<div class="form">
		<form action="{{ url('admin/savePassword') }}" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<table>
				<tr>
					<td>
						<label for="pass">Password Baru <span class="required">*</span></label>
						<input type="password" name="pass" id="pass" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="re_pass">Ulangi</label>
						<input type="password" name="re_pass" id="re_pass" />
					</td>
				</tr>
				<tr>
					<td class="text-right">
						<div class="actions">
							<button class="btn warning"><i class="fa fa-save"></i> ubah password</button>
						</div>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
@endsection