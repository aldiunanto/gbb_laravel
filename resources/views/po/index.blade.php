@extends('base')

@section('content')
<div class="top">
	<div class="tools">
		<div class="search" <?php echo (! is_null($search['s']) ? 'style="display: block;"' : '') ?>>
			<form action="{{ url('po') }}" method="get">
				<i class="fa fa-close"></i>
				<select name="field">
					<option value="po_no" <?php echo $isSelected('po_no') ?>>Nomor PO</option>
					<option value="pb_no" <?php echo $isSelected('pb_no') ?>>Nomor PM</option>
				</select>
				<input type="text" name="s" value="{{ $search['s'] }}" placeholder="Kata pencarian.." />
				<button><i class="fa fa-search"></i></button>
			</form>
		</div>
		<a href="javascript:;" class="btn btn-search warning" <?php echo (! is_null($search['s']) ? 'style="display: none;"' : '') ?>><i class="fa fa-search"></i> Pencarian</a>
	</div>
	<h2>Data List PO <span>{{ $fetch->count() }} dari {{ $fetch->total() }}</span></h2>
	<div class="clearfix"></div>
</div>
<div class="main">
	{!! session('inserted') !!}
	<table class="data-list">
		<thead>
			<tr>
				<th>No</th>
				<th>Nomor PO</th>
				<th>Nomor PM</th>
				<th>Tanggal Order</th>
				<th>Dibutuhkan</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
		<?php $x = $getNumb(); ?>
		@foreach($fetch as $row)

			<tr>
				<td>{{ ++$x }}</td>
				<td>{{ $row->po_no }}</td>
				<td><a class="pm-detail no-print" href="{{ url('material/request/show/' . $row->pb_id) }}">{{ $row->pb_no }}</a></td>
				<td class="text-center">{{ to_indDate($row->po_tgl_buat) }}</td>
				<td class="text-center">{{ to_indDate($row->po_tgl_kedatangan) }}</td>
				<td class="text-right">
					<ul class="actions">
						<li><span><i class="fa fa-angle-down"></i></span>
							<ul>
								<li><a href="{{ url('po/show/' . $row->po_id) }}" class="view-detail {{ (($hak_akses == 3 || $hak_akses == 4) ? 'no-print' : '') }}"><i class="fa fa-eye"></i>Detail PO</a></li>
								<li><a href="{{ url('') }}"><i class="fa fa-list"></i>Detail Penerimaan</a></li>
								
								@if($hak_akses != 3 && $hak_akses != 4)
								<li class="separator">&nbsp;</li>
								<li><a href="{{ url('printing/po/' . $row->po_id) }}" target="_blank"><i class="fa fa-print"></i>Cetak PO</a></li>
								@endif
							</ul>
						</li>
					</ul>
				</td>
			</tr>

		@endforeach
		</tbody>
	</table>

	<?php echo $fetch->render() ?>
</div>
@endsection