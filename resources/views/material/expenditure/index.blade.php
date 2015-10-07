@extends('base')
@section('content')
<div class="top">
	<div class="tools">
		<div class="search" <?php echo (! is_null($search['s']) ? 'style="display: block;"' : '') ?>>
			<form action="{{ url('material/expenditure') }}" method="get">
				<i class="fa fa-close"></i>
				<select name="field">
					<option value="dept" <?php echo $isSelected('dept') ?>>Departemen</option>
					<option value="tgl" <?php echo $isSelected('tgl') ?>>Tanggal</option>
					<option value="bpb" <?php echo $isSelected('bpb') ?>>Nomor BPB</option>
					<option value="pono" <?php echo $isSelected('pono') ?>>Nomor PO</option>
				</select>
				<input type="text" name="s" value="{{ $search['s'] }}" placeholder="Kata pencarian.." />
				<button><i class="fa fa-search"></i></button>
			</form>
		</div>
		<a href="javascript:;" class="btn btn-search warning" <?php echo (! is_null($search['s']) ? 'style="display: none;"' : '') ?>><i class="fa fa-search"></i> Pencarian</a>
		<a href="{{ url('material/expenditure/create') }}" class="btn default"><i class="fa fa-plus"></i> buat pengeluaran</a>
	</div>
	<h2>Daftar Pengeluaran Material <span>0 dari 1</span></h2>
	<div class="clearfix"></div>
</div>
<div class="main">
	{!! session('deleted') !!}
	{!! session('inserted') !!}
	<table class="data-list">
		<thead>
			<tr>
				<th>No</th>
				<th>Departemen</th>
				<th>Tanggal</th>
				<th>Nomor BPB</th>
				<th>Nomor PO</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>
@endsection