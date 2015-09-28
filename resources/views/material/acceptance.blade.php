@extends('base')

@section('content')
<div class="top">
	@if($role == 3 || $role == 1)
	<div class="tools">
		<a href="{{ url('material/acceptance/create') }}" class="btn default acc-default"><i class="fa fa-plus"></i> tambah penerimaan</a>
		<a href="{{ url('material/acceptance/retur/input') }}" class="btn warning"><i class="fa fa-plus"></i> tambah penerimaan returan</a>
	</div>
	@endif
	<h2>Daftar Penerimaan Material</h2>
	<a href="{{ url('material/acceptance/retur') }}">Daftar Retur penerimaan &raquo;</a>

	<div class="clearfix"></div>
</div>
<div class="nav-tabs">
	<a href="{{ url('material/acceptance') }}" class="active">Penerimaan Barang</a>
	<a href="{{ url('material/acceptance/retur/acceptance') }}">Penerimaan Returan</a>
</div>
<div class="main acceptance-list">
	{!! session('deleted') !!}
	{!! session('inserted') !!}
	
	<?php echo $dataListContent ?>

	<fieldset class="label-info">
		<legend>Label Info</legend>
		<ul>
			<li><span class="status pm-reject-vice label">&nbsp;</span> - Terlambat [x] Hari</li>
			<li><span class="status po-done label">&nbsp;</span> - Lebih cepat [x] Hari</li>
			<li><span class="status vice-approve label">&nbsp;</span> - Tepat waktu</li>
		</ul>
	</fieldset>
</div>
@endsection